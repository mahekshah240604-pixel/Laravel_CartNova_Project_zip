<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnRequest extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'order_item_id',
        'reason',
        'message',
        'status',
        'pickup_address',
        'pickup_date',
        'pickup_status',
    ];

    // ✅ Relation: Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // ✅ Relation: User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ✅ Relation: Order Item (optional)
    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }
}