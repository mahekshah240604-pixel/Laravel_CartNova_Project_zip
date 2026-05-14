<?php
// app/Http/Controllers/ReviewController.php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // ── Show Write Review Form ─────────────────────────────────
    // Route: GET /products/{product}/review
    public function create(Product $product)
    {
        // Check if already reviewed
        $existingReview = Review::where('user_id', Auth::id())
                                ->where('product_id', $product->id)
                                ->first();

        // Check if verified purchase
        $verifiedPurchase = Order::where('user_id', Auth::id())
            ->whereHas('items', fn($q) => $q->where('product_id', $product->id))
            ->where('status', '!=', 'cancelled')
            ->exists();

        return view('reviews.create', compact(
            'product', 'existingReview', 'verifiedPurchase'
        ));
    }

    // ── Store Review ───────────────────────────────────────────
    // Route: POST /products/{product}/review
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'title'  => ['nullable', 'string', 'max:150'],
            'body'   => ['nullable', 'string', 'max:2000'],
        ], [
            'rating.required' => 'Please select a star rating.',
            'rating.min'      => 'Rating must be at least 1 star.',
            'rating.max'      => 'Rating cannot exceed 5 stars.',
        ]);

        // Check if verified purchase
        $verifiedPurchase = Order::where('user_id', Auth::id())
            ->whereHas('items', fn($q) => $q->where('product_id', $product->id))
            ->where('status', '!=', 'cancelled')
            ->exists();

        // Create or update review (upsert)
        Review::updateOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $product->id],
            [
                'rating'            => $request->rating,
                'title'             => $request->title,
                'body'              => $request->body,
                'verified_purchase' => $verifiedPurchase,
            ]
        );

        // Update product average rating & review count
        $this->updateProductRating($product);

        return redirect()->route('products.show', $product->id)
                         ->with('success', 'Your review has been submitted successfully!');
    }

    // ── Delete Review ──────────────────────────────────────────
    // Route: DELETE /reviews/{review}
    public function destroy(Review $review)
    {
        // Only owner can delete
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $product = $review->product;
        $review->delete();

        // Update product rating
        $this->updateProductRating($product);

        return back()->with('success', 'Your review has been deleted.');
    }

    // ── Mark Helpful ───────────────────────────────────────────
    // Route: POST /reviews/{review}/helpful
    public function helpful(Request $request, Review $review)
    {
        // Don't let user mark own review as helpful
        if ($review->user_id === Auth::id()) {
            return response()->json(['success' => false, 'message' => 'You cannot mark your own review as helpful.']);
        }

        $review->increment('helpful_count');

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'count'   => $review->helpful_count,
            ]);
        }

        return back()->with('success', 'Marked as helpful!');
    }

    // ── Update Product Average Rating ──────────────────────────
    private function updateProductRating(Product $product)
    {
        $stats = Review::where('product_id', $product->id)
                       ->selectRaw('AVG(rating) as avg_rating, COUNT(*) as total')
                       ->first();

        $product->update([
            'rating'        => round($stats->avg_rating ?? 0, 1),
            'reviews_count' => $stats->total ?? 0,
        ]);
    }
}