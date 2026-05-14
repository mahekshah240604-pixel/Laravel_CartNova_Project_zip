<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Mail\OrderConfirmed;
use Razorpay\Api\Api;

class PaymentController extends Controller
{
    // ── STEP 1: Create Razorpay Order ─────────────────────────
    // Route: POST /payment/create-order
    public function createOrder(Request $request)
    {
        try {
            // Check if request has data
            if ($request->all() === []) {
                Log::error('PaymentController: Empty request received');
                return response()->json([
                    'success' => false,
                    'error' => 'No data received. Please fill all required fields.'
                ], 400);
            }
            
            Log::info('PaymentController: Received data, proceeding with validation');
            
            $request->validate([
                'full_name'      => ['required','string','min:2'],
                'email'          => ['required','email'],
                'phone'          => ['required','digits_between:10,12'],
                'address_line1'  => ['required','string','min:5'],
                'city'           => ['required','string'],
                'state'          => ['required','string'],
                'pincode'        => ['required','digits:6'],
                'payment_method' => ['required','in:razorpay'],
            ], [
                'full_name.required' => 'Full name is required.',
                'email.required' => 'Email is required.',
                'phone.required' => 'Phone number is required.',
                'address_line1.required' => 'Address is required.',
                'city.required' => 'City is required.',
                'state.required' => 'State is required.',
                'pincode.required' => 'Pincode is required.',
                'payment_method.required' => 'Payment method is required.',
            ]);

            try {
                $cartItems = CartItem::with('product')
                    ->where('user_id', Auth::id())
                    ->get()
                    ->filter(fn($i) => $i->product !== null);
            } catch (\Exception $e) {
                Log::error('Error fetching cart items: ' . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'error' => 'Error fetching cart items: ' . $e->getMessage()
                ], 500);
            }

            if ($cartItems->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Your cart is empty. Please add items to continue.'
                ], 400);
            }

            try {
                $subtotal = $cartItems->sum(fn($i) => $i->quantity * $i->product->price);
                Log::info('Subtotal calculated: ' . $subtotal);
            } catch (\Exception $e) {
                Log::error('Error calculating subtotal: ' . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'error' => 'Error calculating subtotal: ' . $e->getMessage()
                ], 500);
            }
            
            $couponDiscount  = session('coupon_discount', 0);
            $couponId        = session('coupon_id');
            $afterCoupon     = max(0, $subtotal - $couponDiscount);
            $deliveryCharge  = $afterCoupon > 499 ? 0 : 40;
            $total           = $afterCoupon + $deliveryCharge;
            
            Log::info('Total calculated: ' . $total);

            try {
                session([
                    'pending_order' => [
                        'full_name' => $request->full_name,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'address_line1' => $request->address_line1,
                        'address_line2' => $request->address_line2,
                        'city' => $request->city,
                        'state' => $request->state,
                        'pincode' => $request->pincode,
                        'payment_method' => $request->payment_method,
                        'subtotal' => $subtotal,
                        'discount' => $couponDiscount,
                        'delivery_charge'=> $deliveryCharge,
                        'total' => $total,
                        'coupon_id' => $couponId,
                        'coupon_discount' => $couponDiscount,
                    ]
                ]);
                Log::info('Session data stored successfully');
            } catch (\Exception $e) {
                Log::error('Error storing session data: ' . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'error' => 'Error storing session data: ' . $e->getMessage()
                ], 500);
            }

            // Create Mock Razorpay order (offline mode)
            try {
                Log::info('Creating Mock Razorpay order for amount: ' . $total);
                $razorpayOrderId = 'order_mock_' . uniqid();
                $mockKey = 'rzp_test_MOCK_KEY_' . substr(md5(time()), 0, 10);
                Log::info('Mock Razorpay order created: ' . $razorpayOrderId);
            } catch (\Exception $e) {
                Log::error('Mock order creation failed: ' . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'error' => 'Payment gateway error: ' . $e->getMessage()
                ], 500);
            }

            $responseData = [
                'success' => true,
                'order_id' => $razorpayOrderId,
                'amount'   => $total * 100,
                'key'      => $mockKey,
                'mock_mode' => true,
            ];
            
            Log::info('PaymentController returning mock response:', $responseData);
            return response()->json($responseData);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'error' => 'Please fill all required fields correctly.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('PaymentController createOrder error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }

    // ── STEP 2: Verify Payment & Place Order ──────────────────
    // Route: POST /payment/verify
    public function verify(Request $request)
    {
        Log::info('PaymentController: verify method called with data: ' . json_encode($request->all()));
        
        $request->validate([
            'razorpay_order_id'   => ['required','string'],
            'razorpay_payment_id' => ['required','string'],
            'razorpay_signature'  => ['required','string'],
        ]);

        // Check if this is a mock payment
        if (str_starts_with($request->razorpay_order_id, 'order_mock_')) {
            Log::info('Processing mock payment verification');
            // Mock payments always succeed
            return $this->placeOrder(
                $request->razorpay_order_id,
                'pay_mock_' . uniqid(),
                'mock_signature_' . substr(md5(time()), 0, 10)
            );
        }

        // Verify signature for real payments
        $secret = config('services.razorpay.secret');
        $expectedSignature = hash_hmac(
            'sha256',
            $request->razorpay_order_id . '|' . $request->razorpay_payment_id,
            $secret
        );

        if (!hash_equals($expectedSignature, $request->razorpay_signature)) {
            return redirect()->route('checkout.index')
                ->with('error', 'Payment verification failed. Please try again.');
        }

        // Place order with payment details
        return $this->placeOrder(
            $request->razorpay_order_id,
            $request->razorpay_payment_id,
            $request->razorpay_signature
        );
    }

    // ── STEP 3: Place Order in DB ──────────────────────────────
    private function placeOrder($rzpOrderId, $rzpPaymentId, $rzpSignature)
    {
        Log::info('PaymentController: placeOrder called with params: ' . json_encode([
            'rzpOrderId' => $rzpOrderId,
            'rzpPaymentId' => $rzpPaymentId,
            'rzpSignature' => $rzpSignature
        ]));
        
        $pending = session('pending_order');

        if (!$pending) {
            return redirect()->route('cart.index')
                ->with('error', 'Session expired. Please try again.');
        }

        $cartItems = CartItem::with('product')
            ->where('user_id', Auth::id())
            ->get()
            ->filter(fn($i) => $i->product !== null);

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        DB::beginTransaction();
        try {
            $isPaid = $rzpPaymentId !== null;

            $order = Order::create([
                'user_id'            => Auth::id(),
                'order_number'       => Order::generateOrderNumber(),
                'status'             => 'pending',
                'full_name'          => $pending['full_name'],
                'phone'              => $pending['phone'],
                'address_line1'      => $pending['address_line1'],
                'address_line2'      => $pending['address_line2'],
                'city'               => $pending['city'],
                'state'              => $pending['state'],
                'pincode'            => $pending['pincode'],
                'payment_method'     => $isPaid ? 'razorpay' : 'cod',
                'payment_status'     => $isPaid ? 'paid' : 'pending',
                'subtotal'           => $pending['subtotal'],
                'discount'           => $pending['discount'],
                'delivery_charge'    => $pending['delivery_charge'],
                'total'              => $pending['total'],
                'notes'              => $pending['notes'] ?? null,
                'placed_at'          => now(),
            ]);

            // Debug: Log order creation
            Log::info('PaymentController: Order created successfully - Order #' . $order->order_number . ', Status: ' . $order->status . ', Total: ' . $order->total);

            // Order items
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
                $item->product->decrement('stock', $item->quantity);
            }

            // Record coupon usage
            if ($pending['coupon_id'] && $pending['coupon_discount'] > 0) {
                CouponUsage::create([
                    'coupon_id'       => $pending['coupon_id'],
                    'user_id'         => Auth::id(),
                    'order_id'        => $order->id,
                    'discount_amount' => $pending['coupon_discount'],
                ]);
                Coupon::find($pending['coupon_id'])?->increment('used_count');
            }

            // Clear cart & session
            CartItem::where('user_id', Auth::id())->delete();
            session()->forget(['coupon_code','coupon_id','coupon_discount','pending_order']);

            DB::commit();

            // Send confirmation email
            try {
                Mail::to(Auth::user()->email)
                    ->send(new OrderConfirmed($order->load('items')));
            } catch (\Exception $e) {}

            return redirect()->route('checkout.success', $order->order_number)
                ->with('order_placed', true);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('checkout.index')
                ->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    // ── Payment Failed ─────────────────────────────────────────
    // Route: GET /payment/failed
    public function failed(Request $request)
    {
        return view('payment.failed', [
            'reason' => $request->get('reason', 'Payment was cancelled or failed.'),
        ]);
    }

    // ── Create Razorpay Order via API ──────────────────────────
    private function createRazorpayOrder(float $amount): string
    {
        // Use correct config keys and ensure they're not null
        $keyId     = config('services.razorpay.key');
        $keySecret = config('services.razorpay.secret');

        // Debug: Check if config values exist
        if (!$keyId || !$keySecret) {
            Log::error('Razorpay config missing - Key: ' . ($keyId ? 'exists' : 'missing') . ', Secret: ' . ($keySecret ? 'exists' : 'missing'));
            throw new \Exception('Razorpay configuration missing. Please check services.php config.');
        }

        Log::info('Making Razorpay API request with key: ' . substr($keyId, 0, 8) . '...');

        $orderData = [
            'amount'          => (int)($amount * 100), // paise
            'currency'        => 'INR',
            'receipt'         => 'rcpt_' . uniqid(),
            'payment_capture' => 1,
        ];

        try {
            $response = Http::withBasicAuth($keyId, $keySecret)
                ->timeout(30) // Add timeout
                ->post('https://api.razorpay.com/v1/orders', $orderData);

            Log::info('Razorpay API response status: ' . $response->status());
            Log::info('Razorpay API response body: ' . $response->body());

            if (!$response->successful()) {
                throw new \Exception('Failed to create Razorpay order: ' . $response->body());
            }

            $orderId = $response->json('id');
            if (!$orderId) {
                throw new \Exception('No order ID returned from Razorpay');
            }

            return $orderId;

        } catch (\Illuminate\Http\Client\RequestException $e) {
            Log::error('Razorpay HTTP request failed: ' . $e->getMessage());
            throw new \Exception('Payment gateway connection failed. Please try again.');
        } catch (\Exception $e) {
            Log::error('Razorpay order creation error: ' . $e->getMessage());
            throw $e;
        }
    }
}
