<?php
// app/Http/Controllers/Admin/AdminController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;

class AdminController extends Controller
{
    // ── Dashboard ──────────────────────────────────────────────
    public function dashboard()
    {
        $stats = [
            'total_users'    => User::count(),
            'total_products' => Product::count(),
            'total_orders'   => Order::count(),
            'total_revenue'  => Order::where('status','!=','cancelled')->sum('total'),
            'pending_orders' => Order::where('status','pending')->count(),
            'low_stock'      => Product::where('stock','<=',5)->count(),
        ];

        $recentOrders = Order::with('user')
            ->latest('placed_at')->limit(8)->get();

        $topProducts = Product::orderBy('reviews_count','desc')
            ->limit(5)->get();

        $ordersByStatus = Order::selectRaw('status, count(*) as count')
            ->groupBy('status')->pluck('count','status');

        return view('admin.dashboard', compact(
            'stats','recentOrders','topProducts','ordersByStatus'
        ));
    }
}