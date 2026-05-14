<?php
// app/Http/Controllers/CheckoutController.php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmed;
use App\Models\Coupon;
use App\Models\Address;
use App\Models\CouponUsage;
use App\Models\Notification;

class CheckoutController extends Controller
{
    // ── STEP 1: Show Checkout Page ─────────────────────────────
    // Route: GET /checkout
    public function index()
    {
        $cartItems = CartItem::with('product')
            ->where('user_id', Auth::id())
            ->get()
            ->filter(fn($i) => $i->product !== null);

        // Redirect if cart empty
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                             ->with('error', 'Your cart is empty. Add items before checkout.');
        }

        // $subtotal      = $cartItems->sum(fn($i) => $i->quantity * $i->product->price);
        // $discount      = $cartItems->sum(fn($i) => $i->product->original_price
        //                     ? ($i->product->original_price - $i->product->price) * $i->quantity : 0);
        // $deliveryCharge = $subtotal > 499 ? 0 : 40;
        // $total         = $subtotal + $deliveryCharge;
        // $itemCount     = $cartItems->sum('quantity');

        $subtotal = $cartItems->sum(fn($i) => $i->quantity * $i->product->price);

// Product discount (already che)
$productDiscount = $cartItems->sum(fn($i) => $i->product->original_price
    ? ($i->product->original_price - $i->product->price) * $i->quantity : 0);

// Coupon discount (session mathi)
$couponDiscount = session('coupon_discount', 0);

// Final discount (banne add)
$discount = $productDiscount + $couponDiscount;

// Final subtotal (coupon pachi)
$finalSubtotal = max(0, $subtotal - $couponDiscount);

// Delivery charge coupon pachi check karvanu
$deliveryCharge = $finalSubtotal > 499 ? 0 : 40;

// Final total
$total = $finalSubtotal + $deliveryCharge;

$itemCount = $cartItems->sum('quantity');

        return view('checkout.index', compact(
            'cartItems', 'subtotal', 'discount',
            'deliveryCharge', 'total', 'itemCount'
        ));
    }

    // ── STEP 2: Place Order ────────────────────────────────────
    // Route: POST /checkout/place-order
    public function placeOrder(Request $request)
    {
        // // 1. Validate shipping + payment
        // $request->validate([
        //     'full_name'    => ['required', 'string', 'min:2', 'max:100'],
        //     'phone'        => ['required', 'digits_between:10,12'],
        //     'address_line1'=> ['required', 'string', 'min:5', 'max:255'],
        //     'address_line2'=> ['nullable', 'string', 'max:255'],
        //     'city'         => ['required', 'string', 'max:100'],
        //     'state'        => ['required', 'string', 'max:100'],
        //     'pincode'      => ['required', 'digits:6'],
        //     'payment_method' => ['required', 'in:cod,card,upi'],
            
        // ], [
        //     'full_name.required'     => 'Enter your full name.',
        //     'phone.required'         => 'Enter your phone number.',
        //     'phone.digits_between'   => 'Enter a valid 10-digit phone number.',
        //     'address_line1.required' => 'Enter your street address.',
        //     'city.required'          => 'Enter your city.',
        //     'state.required'         => 'Select your state.',
        //     'pincode.required'       => 'Enter your 6-digit pincode.',
        //     'pincode.digits'         => 'Pincode must be exactly 6 digits.',
        //     'payment_method.required'=> 'Select a payment method.',
        // ]);
     if ($request->payment_method === 'razorpay') {
            // Validate basic info only for Razorpay
            $request->validate([
                'full_name'    => ['required', 'string', 'min:2', 'max:100'],
                'phone'        => ['required', 'digits_between:10,12'],
                'address_line1'=> ['required', 'string', 'min:5', 'max:255'],
                'city'         => ['required', 'string', 'max:100'],
                'state'        => ['required', 'string', 'max:100'],
                'pincode'      => ['required', 'digits:6'],
            ], [
                'full_name.required'     => 'Enter your full name.',
                'phone.required'         => 'Enter your phone number.',
                'address_line1.required' => 'Enter your street address.',
                'city.required'          => 'Enter your city.',
                'state.required'         => 'Select your state.',
                'pincode.required'       => 'Enter your 6-digit pincode.',
            ]);

            // Forward to PaymentController for Razorpay processing
            return app()->make(\App\Http\Controllers\PaymentController::class)->createOrder($request);
        }

        // Step 1: Rules
$rules = [
    'full_name'    => ['required', 'string', 'min:2', 'max:100'],
    'phone'        => ['required', 'digits_between:10,12'],
    'address_line1'=> ['required', 'string', 'min:5', 'max:255'],
    'city'         => ['required', 'string', 'max:100'],
    'state'        => ['required', 'string', 'max:100'],
    'pincode'      => ['required', 'digits:6'],
    'payment_method' => ['required', 'in:cod,card,upi,razorpay'],
];

// Step 2: Conditional
if ($request->payment_method === 'card') {
    $rules['card_number'] = ['required', 'digits_between:12,19'];
    $rules['card_name']   = ['required'];
    $rules['card_expiry'] = ['required'];
    $rules['card_cvv']    = ['required', 'digits:3'];
}

if ($request->payment_method === 'upi') {
    $rules['upi_id'] = ['required', 'regex:/^[\w.\-]+@[\w.\-]+$/'];
}

// Step 3: Validate with ALL messages
$request->validate($rules, [

    // ✅ Old messages (keep these)
    'full_name.required'     => 'Enter your full name.',
    'phone.required'         => 'Enter your phone number.',
    'phone.digits_between'   => 'Enter a valid 10-digit phone number.',
    'address_line1.required' => 'Enter your street address.',
    'city.required'          => 'Enter your city.',
    'state.required'         => 'Select your state.',
    'pincode.required'       => 'Enter your 6-digit pincode.',
    'pincode.digits'         => 'Pincode must be exactly 6 digits.',
    'payment_method.required'=> 'Select a payment method.',

    // 🔥 New messages (add these)
    'card_number.required' => 'Enter card number.',
    'card_cvv.required'    => 'Enter CVV.',
    'upi_id.required'      => 'Enter UPI ID.',
]);

        // 2. Get cart items
        $cartItems = CartItem::with('product')
            ->where('user_id', Auth::id())
            ->get()
            ->filter(fn($i) => $i->product !== null);

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                             ->with('error', 'Your cart is empty.');
        }

        // 3. Calculate totals
        // $subtotal       = $cartItems->sum(fn($i) => $i->quantity * $i->product->price);
        // $discount       = $cartItems->sum(fn($i) => $i->product->original_price
        //                     ? ($i->product->original_price - $i->product->price) * $i->quantity : 0);
        // $deliveryCharge = $subtotal > 499 ? 0 : 40;
        // $total          = $subtotal + $deliveryCharge;

        $subtotal       = $cartItems->sum(fn($i) => $i->quantity * $i->product->price);
$productDiscount = $cartItems->sum(fn($i) => $i->product->original_price
    ? ($i->product->original_price - $i->product->price) * $i->quantity : 0);

// ✅ Coupon data session mathi
$couponDiscount = session('coupon_discount', 0);
$couponId       = session('coupon_id');

// ✅ Final discount
$discount = $productDiscount + $couponDiscount;

// ✅ Delivery charge (coupon apply pachi check)
$deliveryCharge = max(0, $subtotal - $couponDiscount) > 499 ? 0 : 40;

// ✅ Final total
$total = max(0, $subtotal - $couponDiscount) + $deliveryCharge;

        // 4. Create order inside transaction
        DB::beginTransaction();
        try {
            // Create order
            $order = Order::create([
                'user_id'        => Auth::id(),
                'order_number'   => Order::generateOrderNumber(),
                'status'         => 'pending',
                'full_name'      => $request->full_name,
                'phone'          => $request->phone,
                'address_line1'  => $request->address_line1,
                'address_line2'  => $request->address_line2,
                'city'           => $request->city,
                'state'          => $request->state,
                'pincode'        => $request->pincode,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_method === 'cod' ? 'pending' : 'paid',
                'subtotal'       => $subtotal,
                'discount'       => $discount,
                'delivery_charge'=> $deliveryCharge,
                'total'          => $total,
                'notes'          => $request->notes,
                'placed_at'      => now(),
            ]);
            if ($couponId) {
                $order->coupon_id = $couponId;
                $order->save();
            }
            // Create order items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id'       => $order->id,
                    'product_id'     => $item->product->id,
                    'product_name'   => $item->product->name,
                    'product_brand'  => $item->product->brand,
                    'product_image'  => $item->product->image,
                    'price'          => $item->product->price,
                    'original_price' => $item->product->original_price,
                    'quantity'       => $item->quantity,
                    'subtotal'       => $item->quantity * $item->product->price,
                ]);

                // Reduce stock
                $item->product->decrement('stock', $item->quantity);
            }

            // ✅ Record coupon usage
if ($couponId) {
    CouponUsage::create([
        'coupon_id'       => $couponId,
        'user_id'         => Auth::id(),
        'order_id'        => $order->id,
        'discount_amount' => $couponDiscount,
    ]);

    // ✅ Increment usage count
    // Coupon::find($couponId)?->increment('used_count');
    // $coupon = Coupon::find($couponId);
     Coupon::find($couponId)?->increment('used_count');
                session()->forget(['coupon_code','coupon_id','coupon_discount']);
    }

    // ✅ Clear clear
    CartItem::where('user_id', Auth::id())->delete();

            // // Clear cart
            // CartItem::where('user_id', Auth::id())->delete();

            DB::commit();
                        // Redirect to success page
            // Send notification
            try {
                Notification::send(
                    Auth::id(),
                    'order_confirmed',
                    'Order Confirmed! 🎉',
                    'Your order #' . $order->order_number . ' has been placed. Total: ₹' . number_format($order->total, 0),
                    route('orders.show', $order->order_number),
                    '✅'
                );
            } catch (\Exception $e) {}

            // 7. SEND EMAIL (IMPORTANT PART 🔥)
            Mail::to(Auth::user()->email)
                ->send(new OrderConfirmed($order->load('items')));


            // Redirect to success page
            return redirect()->route('checkout.success', $order->order_number)
                             ->with('order_placed', true);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong. Please try again.')
                         ->withInput();
        }
    }

    // ── STEP 3: Order Success Page ─────────────────────────────
    // Route: GET /checkout/success/{orderNumber}
    public function success($orderNumber)
    {
        $order = Order::with('items')
            ->where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->firstOrFail();

            
        return view('checkout.success', compact('order'));
    }

    public function applyCoupon(Request $request)
{
    $request->validate([
        'coupon_code' => 'required|string'
    ]);

    // $coupon = Coupon::where('code', $request->coupon_code)
    //     ->where('is_active', 1)
    //     ->first();
    $coupon = Coupon::whereRaw('LOWER(code) = ?', [strtolower($request->coupon_code)])
    ->where('is_active', 1)
    ->first();

    if (!$coupon) {
        return back()->with('coupon_error', 'Invalid coupon code');
    }

    // Check expiry
    if ($coupon->expires_at && now()->gt($coupon->expires_at)) {
        return back()->with('coupon_error', 'Coupon expired');
    }

    // Get cart total
    $cartItems = CartItem::with('product')
        ->where('user_id', Auth::id())
        ->get();

    $subtotal = $cartItems->sum(fn($i) => $i->quantity * $i->product->price);

    // Minimum amount check
    if ($coupon->min_order_amount && $subtotal < $coupon->min_order_amount) {
        return back()->with('coupon_error', 'Minimum order not reached');
    }

    // Discount calculate
    if ($coupon->type === 'percentage') {
        $discount = ($subtotal * $coupon->value) / 100;
    } else {
        $discount = $coupon->value;
    }

    return back()->with([
        'coupon_success'  => 'Coupon applied!',
        'coupon_code'     => $coupon->code,
        'coupon_id'       => $coupon->id,
        'coupon_discount' => $discount
    ]);
}
}