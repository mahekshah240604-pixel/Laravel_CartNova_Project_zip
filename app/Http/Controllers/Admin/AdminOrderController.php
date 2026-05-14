<?php
// app/Http/Controllers/Admin/AdminOrderController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Notification;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    // List all orders
    public function index(Request $request)
    {
        $query = Order::with('user','items');

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where('order_number','like','%'.$request->search.'%')
                  ->orWhereHas('user', fn($q) => $q->where('name','like','%'.$request->search.'%'));
        }

        $orders = $query->latest('placed_at')->paginate(15)->withQueryString();
        return view('admin.orders.index', compact('orders'));
    }

    // View single order
    public function show(Order $order)
    {
        $order->load('user','items');
        return view('admin.orders.show', compact('order'));
    }

    // Update order status
    public function updateStatus(Request $request, Order $order)
    {
    //     $request->validate([
    //         'status' => ['required','in:pending,confirmed,shipped,delivered,cancelled'],
    //     ]);

    //     $order->update(['status' => $request->status]);

    //     return back()->with('success', 'Order status updated to "'.$request->status.'".');
    // }
     $request->validate([
            'status' => ['required','in:pending,confirmed,shipped,delivered,cancelled'],
        ]);
        // 🔥 Allowed flow rule
    $allowed = [
        'pending' => ['confirmed', 'cancelled'],
        'confirmed' => ['shipped', 'cancelled'],
        'shipped' => ['delivered'],
        'delivered' => [],
        'cancelled' => [],
    ];

    $current = $order->status;
    $new = $request->status;

    if (!in_array($new, $allowed[$current])) {
        return back()->with('error', 'Invalid status change');
    }
 
        $order->update(['status' => $request->status]);
        // update status
    // $order->update(['status' => $new]);
 
        // Notify customer of status change
        $statusMessages = [
            'confirmed'  => '✅ Your order #' . $order->order_number . ' has been confirmed!',
            'shipped'    => '🚚 Your order #' . $order->order_number . ' has been shipped and is on its way!',
            'delivered'  => '🏠 Your order #' . $order->order_number . ' has been delivered. Enjoy!',
            'cancelled'  => '❌ Your order #' . $order->order_number . ' has been cancelled.',
        ];
        $titles = [
            'confirmed'  => 'Order Confirmed! ✅',
            'shipped'    => 'Order Shipped! 🚚',
            'delivered'  => 'Order Delivered! 🏠',
            'cancelled'  => 'Order Cancelled ❌',
        ];
         // Send notification
        if (isset($statusMessages[$request->status])) {
            try {
                Notification::send(
                    $order->user_id,
                    'order_' . $request->status,
                    $titles[$request->status],
                    $statusMessages[$request->status],
                    route('orders.show', $order->order_number),
                );
            } catch (\Exception $e) {}
        }
 
        // return back()->with('success', 'Order status updated to "'.$request->status.'".');
        return back()->with('success', 'Order status updated!');
    }
    // ❌ DELETE ORDER (NEW)
    public function destroy(Order $order)
    {
        try {
            $order->delete();

            return redirect()->route('admin.orders.index')
                ->with('success', 'Order deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete order.');
        }
    }
}