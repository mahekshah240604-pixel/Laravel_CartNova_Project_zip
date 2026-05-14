<?php
// app/Http/Controllers/CartController.php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\SavedItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // ── Show Cart ──────────────────────────────
    // Route: GET /cart
    public function index()
    {
        $cartItems = CartItem::with('product')
            ->where('user_id', Auth::id())
            ->get();

        // Remove items whose product was deleted
        $cartItems = $cartItems->filter(fn($item) => $item->product !== null);

        $subtotal  = $cartItems->sum(fn($item) => $item->quantity * $item->product->price);
        $discount  = $cartItems->sum(fn($item) =>
            $item->product->original_price
                ? ($item->product->original_price - $item->product->price) * $item->quantity
                : 0
        );
        $delivery  = $subtotal > 499 ? 0 : 40;
        $total     = $subtotal + $delivery;
        $itemCount = $cartItems->sum('quantity');

        return view('cart.index', compact(
            'cartItems', 'subtotal', 'discount', 'delivery', 'total', 'itemCount'
        ));
    }

    // ── Add to Cart ────────────────────────────
    // Route: POST /cart/add
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity'   => ['integer', 'min:1', 'max:10'],
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check stock
        if ($product->stock < 1) {
            return back()->with('error', 'Sorry, this product is out of stock.');
        }

        // Add or update cart
        $cartItem = CartItem::where('user_id', Auth::id())
                            ->where('product_id', $request->product_id)
                            ->first();

        if ($cartItem) {
            // Increase quantity (max 10)
            $newQty = min($cartItem->quantity + ($request->quantity ?? 1), 10);
            $cartItem->update(['quantity' => $newQty]);
            $message = 'Quantity updated in cart!';
        } else {
            CartItem::create([
                'user_id'    => Auth::id(),
                'product_id' => $request->product_id,
                'quantity'   => $request->quantity ?? 1,
            ]);
            $message = '"' . $product->name . '" added to cart!';
        }

        // AJAX response
        if ($request->ajax()) {
            $count = CartItem::where('user_id', Auth::id())->sum('quantity');
            return response()->json(['success' => true, 'message' => $message, 'count' => $count]);
        }

        return back()->with('success', $message);
    }

    // ── Update Quantity ────────────────────────
    // Route: POST /cart/update
    public function update(Request $request)
    {
        $request->validate([
            'cart_item_id' => ['required', 'exists:cart_items,id'],
            'quantity'     => ['required', 'integer', 'min:1', 'max:10'],
        ]);

        $cartItem = CartItem::where('id', $request->cart_item_id)
                            ->where('user_id', Auth::id())
                            ->firstOrFail();

        $cartItem->update(['quantity' => $request->quantity]);

        if ($request->ajax()) {
            $subtotal  = CartItem::with('product')->where('user_id', Auth::id())->get()
                            ->sum(fn($i) => $i->quantity * $i->product->price);
            $delivery  = $subtotal > 499 ? 0 : 40;
            $total     = $subtotal + $delivery;
            $itemCount = CartItem::where('user_id', Auth::id())->sum('quantity');

            return response()->json([
                'success'       => true,
                'item_subtotal' => '₹' . number_format($cartItem->quantity * $cartItem->product->price, 0),
                'subtotal'      => '₹' . number_format($subtotal, 0),
                'delivery'      => $delivery == 0 ? 'FREE' : '₹' . $delivery,
                'total'         => '₹' . number_format($total, 0),
                'item_count'    => $itemCount,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Cart updated!');
    }

    // ── Remove Item ────────────────────────────
    // Route: POST /cart/remove
    public function remove(Request $request)
    {
        $request->validate([
            'cart_item_id' => ['required', 'exists:cart_items,id'],
        ]);

        CartItem::where('id', $request->cart_item_id)
                ->where('user_id', Auth::id())
                ->delete();

        // if ($request->ajax()) {
        //     $count = CartItem::where('user_id', Auth::id())->sum('quantity');
        //     return response()->json(['success' => true, 'count' => $count]);
        // }
        // 🔥 Recalculate cart
         $cartItems = CartItem::with('product')
        ->where('user_id', Auth::id())
        ->get();


            $subtotal = $cartItems->sum(fn($item) => $item->quantity * $item->product->price);
            $delivery = $subtotal > 499 ? 0 : 40;
            $total    = $subtotal + $delivery;
            $count    = $cartItems->sum('quantity');

           return response()->json([
            'success'  => true,
            'count'    => $count,
            'subtotal' => '₹' . number_format($subtotal, 0),
            'delivery' => $delivery == 0 ? 'FREE' : '₹' . $delivery,
            'total'    => '₹' . number_format($total, 0),
    ]);

        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }

    // ── Clear Cart ─────────────────────────────
    // Route: POST /cart/clear
    public function clear()
    {
        CartItem::where('user_id', Auth::id())->delete();
        return redirect()->route('cart.index')->with('success', 'Cart cleared.');
    }

    // ── Cart Count (AJAX) ──────────────────────
    // Route: GET /cart/count
    public function count()
    {
        $count = CartItem::where('user_id', Auth::id())->sum('quantity');
        return response()->json(['count' => $count]);
    }

    // ── Save for Later ──────────────────────────
// Route: POST /cart/save/{productId}
public function saveForLater($productId)
{
    $userId = Auth::id();

    // Save item
    SavedItem::firstOrCreate([
        'user_id' => $userId,
        'product_id' => $productId
    ]);

    // Remove from cart
    CartItem::where('user_id', $userId)
        ->where('product_id', $productId)
        ->delete();

    return redirect()->route('cart.index')
        ->with('success', 'Product moved to Save for Later');
}
}