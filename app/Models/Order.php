<?php
// app/Models/Order.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'order_number', 'status',
        'full_name', 'phone', 'address_line1', 'address_line2',
        'city', 'state', 'pincode',
        'payment_method', 'payment_status',
        'subtotal', 'discount', 'delivery_charge', 'total',
        'notes', 'placed_at',
    ];

    protected $casts = [
        'placed_at' => 'datetime',
        'subtotal'  => 'decimal:2',
        'discount'  => 'decimal:2',
        'total'     => 'decimal:2',
    ];

    // ── Relationships ─────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function returns()
{
    return $this->hasMany(\App\Models\ReturnRequest::class);
}

    // ── Helpers ───────────────────────────────────
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pending'   => ['label' => 'Order Placed',  'color' => '#FF9900'],
            'confirmed' => ['label' => 'Confirmed',     'color' => '#007185'],
            'shipped'   => ['label' => 'Shipped',       'color' => '#0066C0'],
            'delivered' => ['label' => 'Delivered',     'color' => '#007600'],
            'cancelled' => ['label' => 'Cancelled',     'color' => '#CC0C39'],
             // ✅ ADD THIS LINE ONLY
             'returned'  => ['label' => 'Return Completed', 'color' => '#28a745'],
            default     => ['label' => ucfirst($this->status), 'color' => '#565959'],
        };
    }

    public function getPaymentLabelAttribute()
    {
        return match($this->payment_method) {
            'cod'  => 'Cash on Delivery',
            'card' => 'Credit / Debit Card',
            'upi'  => 'UPI Payment',
            default => ucfirst($this->payment_method),
        };
    }

    // Generate unique order number
    public static function generateOrderNumber()
    {
        return 'CNV-'. date('ymd') . '-'  . strtoupper(uniqid()) . '-' . rand(100, 999);
    }
}