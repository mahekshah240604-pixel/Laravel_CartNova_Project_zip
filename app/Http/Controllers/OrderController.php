<?php
// app/Http/Controllers/OrderController.php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\OrderItem;
use App\Mail\OrderCancelled;
use App\Models\SavedItem;


class OrderController extends Controller
{
    // ── All Orders ─────────────────────────────────────────────
    // Route: GET /orders
    public function index(Request $request)
    {
        $query = Order::with('items')
            ->where('user_id', Auth::id())
            ->latest('placed_at');

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by date
        if ($request->filled('period')) {
            $query->where('placed_at', '>=', match($request->period) {
                '30days'  => now()->subDays(30),
                '6months' => now()->subMonths(6),
                '1year'   => now()->subYear(),
                default   => now()->subYears(10),
            });
        }

        // Search by order number
        if ($request->filled('search')) {
            $query->where('order_number', 'like', '%' . $request->search . '%');
        }

        $orders = $query->paginate(5)->withQueryString();

         // ✅ Saved items fetch karo
    $savedItems = SavedItem::with('product')
        ->where('user_id', Auth::id())
        ->get();

        return view('orders.index', compact('orders','savedItems'));
    }

    // ── Order Detail ───────────────────────────────────────────
    // Route: GET /orders/{orderNumber}
    public function show($orderNumber)
    {
        $order = Order::with('items')
            ->where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('orders.show', compact('order'));
    }

    // ── Cancel Order ───────────────────────────────────────────
    // Route: POST /orders/{orderNumber}/cancel
    public function cancel($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Only pending or confirmed orders can be cancelled
        if (!in_array($order->status, ['pending', 'confirmed'])) {
            return back()->with('error', 'This order cannot be cancelled as it has already been ' . $order->status . '.');
        }

        // Restore stock
        foreach ($order->items as $item) {
            if ($item->product) {
                $item->product->increment('stock', $item->quantity);
            }
        }

        $order->update([
            'status'         => 'cancelled',
            'payment_status' => $order->payment_method === 'cod' ? 'cancelled' : 'refund_initiated',
        ]);
        // Send Order Cancelled Email
        Mail::to($order->user->email)->send(new OrderCancelled($order->load('items')));

        return back()->with('success', 'Order #' . $orderNumber . ' has been cancelled successfully.');
    }
     // ── ❌ Remove Single Item (ADMIN) ───────────────────────────
    public function removeItem($id)
    {
        $item = OrderItem::findOrFail($id);
        $order = $item->order;

        // (Optional) Admin check
        // if (!auth()->user()->is_admin) {
        //     abort(403);
        // }

        // Delete item
        $item->delete();

        // Recalculate totals
        $order->subtotal = $order->items()->sum('subtotal');
        $order->total = $order->subtotal - $order->discount + $order->delivery_charge;

        $order->save();

        return back()->with('success', 'Item removed successfully');
    }
}