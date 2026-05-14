<?php
// app/Http/Controllers/CouponController.php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    // ── Apply Coupon (AJAX from cart/checkout) ─────────────────
    // Route: POST /coupon/apply
    public function apply(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string'],
        ]);

        // Get cart total
        $cartItems = CartItem::with('product')
            ->where('user_id', Auth::id())
            ->get()
            ->filter(fn($i) => $i->product !== null);

        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty.',
            ]);
        }

        $cartTotal = $cartItems->sum(fn($i) => $i->quantity * $i->product->price);

        // Find coupon (case-insensitive)
        $coupon = Coupon::whereRaw('UPPER(code) = ?', [strtoupper(trim($request->code))])->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid coupon code. Please check and try again.',
            ]);
        }

        // Validate coupon
        $validation = $coupon->validate($cartTotal, Auth::id());

        if (!$validation['valid']) {
            return response()->json([
                'success' => false,
                'message' => $validation['message'],
            ]);
        }

        // Calculate discount
        $discount = $coupon->calculateDiscount($cartTotal);
        $newTotal = max(0, $cartTotal - $discount);
        $delivery = $newTotal > 499 ? 0 : 40;

        // Store in session
        session([
            'coupon_code'     => $coupon->code,
            'coupon_id'       => $coupon->id,
            'coupon_discount' => $discount,
        ]);

        return response()->json([
            'success'      => true,
            'message'      => '🎉 Coupon "' . $coupon->code . '" applied! You save ₹' . number_format($discount, 0),
            'code'         => $coupon->code,
            'type_label'   => $coupon->type_label,
            'description'  => $coupon->description,
            'discount'     => '₹' . number_format($discount, 0),
            'discount_raw' => $discount,
            'new_total'    => '₹' . number_format($newTotal + $delivery, 0),
            'subtotal'     => '₹' . number_format($cartTotal, 0),
            'delivery'     => $delivery == 0 ? 'FREE' : '₹' . $delivery,
        ]);
    }

    // ── Remove Coupon ──────────────────────────────────────────
    // Route: POST /coupon/remove
    public function remove()
    {
        session()->forget(['coupon_code', 'coupon_id', 'coupon_discount']);

        return response()->json([
            'success' => true,
            'message' => 'Coupon removed.',
        ]);
    }

    // ── Validate only (no apply) ───────────────────────────────
    // Route: POST /coupon/check
    public function check(Request $request)
    {
        $request->validate(['code' => ['required', 'string']]);

        $cartItems = CartItem::with('product')
            ->where('user_id', Auth::id())
            ->get()
            ->filter(fn($i) => $i->product !== null);

        $cartTotal = $cartItems->sum(fn($i) => $i->quantity * $i->product->price);

        $coupon = Coupon::whereRaw('UPPER(code) = ?', [strtoupper(trim($request->code))])->first();

        if (!$coupon) {
            return response()->json(['valid' => false, 'message' => 'Invalid coupon code.']);
        }

        $validation = $coupon->validate($cartTotal, Auth::id());
        return response()->json(array_merge($validation, ['type_label' => $coupon->type_label]));
    }
}