<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponUsage extends Model
{
    protected $fillable = [
        'coupon_id', 'user_id', 'order_id', 'discount_amount',
    ];

    // ✅ ALL RELATIONSHIPS SAFE (string use kari)
    public function coupon()
    {
        return $this->belongsTo('App\Models\Coupon');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }
}