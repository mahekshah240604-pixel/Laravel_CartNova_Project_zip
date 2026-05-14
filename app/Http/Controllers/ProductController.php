<?php
// app/Http/Controllers/ProductController.php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Product listing page with search, filter, sort
     * Route: GET /products
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // ── 1. Search ──────────────────────────────
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // ── 2. Category filter ─────────────────────
        if ($request->filled('category') && $request->category !== 'All') {
            $query->where('category', $request->category);
        }

        // ── 3. Price range filter ──────────────────
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // ── 4. Rating filter ───────────────────────
        if ($request->filled('rating')) {
            $query->where('rating', '>=', $request->rating);
        }

        // ── 5. Prime filter ────────────────────────
        if ($request->boolean('prime')) {
            $query->where('is_prime', true);
        }
        

        // ── 6. Sort ────────────────────────────────
        $sort = $request->get('sort', 'featured');
        match ($sort) {
            'price_low'  => $query->orderBy('price', 'asc'),
            'price_high' => $query->orderBy('price', 'desc'),
            'rating'     => $query->orderBy('rating', 'desc'),
            'newest'     => $query->orderBy('created_at', 'desc'),
            'discount'   => $query->orderBy('discount', 'desc'),
            'best_selling' => $query->orderBy('sold_count', 'desc'),
             'popular'      => $query->orderBy('views', 'desc'),
            default      => $query->orderBy('is_featured', 'desc')->orderBy('rating', 'desc'),

            
        };

        // ── 7. Paginate ────────────────────────────
        $products = $query->paginate(12)->withQueryString();

        // ── 8. Categories for sidebar ──────────────
        $categories = Product::distinct()->pluck('category')->sort()->values();
        $categoryIcons = [
                'Books' => '📚',
                'Electronics' => '📱',
                'Fashion' => '👗',
                'Home & Kitchen' => '🏠',
                'Sports' => '⚽',
            ];

        // ── 9. Total count ─────────────────────────
        $totalCount = $query->toBase()->getCountForPagination();

        return view('products.index', compact(
            'products', 'categories', 'categoryIcons','sort', 'totalCount'
        ));
    }

    /**
     * Single product detail page
     * Route: GET /products/{id}
     */
    public function show(Product $product)
    {
        // 🔥 views increase (popular sorting માટે)
    $product->increment('views');
        $related = Product::where('category', $product->category)
                          ->where('id', '!=', $product->id)
                          ->inRandomOrder()
                          ->limit(4)
                          ->get();
                
        $reviews = Review::with('user')
                         ->where('product_id', $product->id)
                         ->latest()
                         ->get();

        return view('products.show', compact('product', 'related','reviews'));
    }
}