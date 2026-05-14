<?php
// app/Http/Controllers/WishlistController.php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Mail;
// use App\Mail\WishlistItemSavedMail;

class WishlistController extends Controller
{
    // ── Show Wishlist ──────────────────────────────────────────
    // Route: GET /wishlist
    public function index()
    {
        $wishlistItems = Wishlist::with('product')
            ->where('user_id', Auth::id())
            ->latest()
            ->get()
            ->filter(fn($item) => $item->product !== null);

        $wishlistCount = $wishlistItems->count();

        return view('wishlist.index', compact('wishlistItems', 'wishlistCount'));
    }

    // ── Toggle Wishlist (Add/Remove) ───────────────────────────
    // Route: POST /wishlist/toggle
    public function toggle(Request $request)
    {
        //  $request->validate([
        //      'product_id' => ['required', 'exists:products,id'],
        //  ]);

        //  $existing = Wishlist::where('user_id', Auth::id())
        //                      ->where('product_id', $request->product_id)
        //                      ->first();

        //  if ($existing) {
        //      $existing->delete();
        //      $active  = 'removed';
        //      $message = 'Removed from wishlist.';
        //  } else {
        //      $wishlistItem=Wishlist::create([
        //          'user_id'    => Auth::id(),
        //          'product_id' => $request->product_id,
        //     ]);
        //      $action  = 'added';
        //      $message = 'Added to wishlist!';
        //           Mail::to(Auth::user()->email)
        // ->send(new WishlistItemSavedMail($wishlistItem, Auth::user()));
        //  }

        //  $count = Wishlist::where('user_id', Auth::id())->count();

        //  if ($request->ajax()) {
        //      return response()->json([
        //          'success' => true,
        //          'action'  => $action,
        //          'message' => $message,
        //          'count'   => $count,
        //      ]);
        //  }

        //  return back()->with('success', $message);
        $request->validate([
        'product_id' => ['required', 'exists:products,id'],
    ]);

    $existing = Wishlist::where('user_id', Auth::id())
                        ->where('product_id', $request->product_id)
                        ->first();

    if ($existing) {
        $existing->delete();
        $status  = 'removed';
        $message = 'Removed from wishlist.';
    } else {
        $wishlistItem= Wishlist::create([
            'user_id'    => Auth::id(),
            'product_id' => $request->product_id,
        ]);
        $status  = 'added';
        $message = 'Added to wishlist!';

        //  Mail::to(Auth::user()->email)
        // ->send(new WishlistItemSavedMail($wishlistItem, Auth::user()));
    }

    $count = Wishlist::where('user_id', Auth::id())->count();

    return response()->json([
        'success' => true,
        'status'  => $status,   // 🔥 IMPORTANT (JS mate)
        'message' => $message,
        'count'   => $count,
    ]);
    }

    // ── Remove from Wishlist ───────────────────────────────────
    // Route: POST /wishlist/remove
    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
        ]);

        Wishlist::where('user_id', Auth::id())
                ->where('product_id', $request->product_id)
                ->delete();

        $count = Wishlist::where('user_id', Auth::id())->count();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'count' => $count]);
        }

        return back()->with('success', 'Item removed from wishlist.');
    }

    // ── Move to Cart ───────────────────────────────────────────
    // Route: POST /wishlist/move-to-cart
    public function moveToCart(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < 1) {
            return back()->with('error', 'Sorry, this product is out of stock.');
        }

        // Add to cart
        $cartItem = CartItem::where('user_id', Auth::id())
                            ->where('product_id', $request->product_id)
                            ->first();

        if ($cartItem) {
            $cartItem->update(['quantity' => min($cartItem->quantity + 1, 10)]);
        } else {
            CartItem::create([
                'user_id'    => Auth::id(),
                'product_id' => $request->product_id,
                'quantity'   => 1,
            ]);
        }

        // Remove from wishlist
        Wishlist::where('user_id', Auth::id())
                ->where('product_id', $request->product_id)
                ->delete();

        return back()->with('success', '"' . $product->name . '" moved to cart!');
    }

    // ── Move All to Cart ───────────────────────────────────────
    // Route: POST /wishlist/move-all-to-cart
    public function moveAllToCart()
    {
        $wishlistItems = Wishlist::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $moved = 0;
        foreach ($wishlistItems as $item) {
            if ($item->product && $item->product->stock > 0) {
                $cartItem = CartItem::where('user_id', Auth::id())
                                    ->where('product_id', $item->product_id)
                                    ->first();
                if ($cartItem) {
                    $cartItem->update(['quantity' => min($cartItem->quantity + 1, 10)]);
                } else {
                    CartItem::create([
                        'user_id'    => Auth::id(),
                        'product_id' => $item->product_id,
                        'quantity'   => 1,
                    ]);
                }
                $item->delete();
                $moved++;
            }
        }

        return redirect()->route('cart.index')
                         ->with('success', $moved . ' item(s) moved to cart!');
    }

    // ── Wishlist Count (AJAX) ──────────────────────────────────
    // Route: GET /wishlist/count
    public function count()
    {
        $count = Wishlist::where('user_id', Auth::id())->count();
        return response()->json(['count' => $count]);
    }
}