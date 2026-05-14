<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'description', 'type', 'value',
        'min_order_amount', 'max_discount',
        'usage_limit', 'used_count', 'per_user_limit',
        'is_active', 'starts_at', 'expires_at',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'starts_at'  => 'datetime',
        'expires_at' => 'datetime',
    ];

    // Relationships
    public function usages()
    {
        return $this->hasMany(\App\Models\CouponUsage::class);
    }

    public function orders()
    {
        return $this->hasMany(\App\Models\Order::class);
    }

    // Accessors
    public function getTypeLabelAttribute()
    {
        return ucfirst($this->type);
    }

    public function getStatusAttribute()
    {
        if (!$this->is_active) {
            return 'inactive';
        }
        
        if ($this->starts_at && now()->lt($this->starts_at)) {
            return 'upcoming';
        }
        
        if ($this->expires_at && now()->gt($this->expires_at)) {
            return 'expired';
        }
        
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return 'exhausted';
        }
        
        return 'active';
    }

    // Validation Methods
    public function validate($cartTotal = 0, $userId = null)
    {
        // Check if coupon is active
        if (!$this->is_active) {
            return [
                'valid' => false,
                'message' => 'This coupon is not active.'
            ];
        }

        // Check start date
        if ($this->starts_at && now()->lt($this->starts_at)) {
            return [
                'valid' => false,
                'message' => 'This coupon is not yet active.'
            ];
        }

        // Check expiry date
        if ($this->expires_at && now()->gt($this->expires_at)) {
            return [
                'valid' => false,
                'message' => 'This coupon has expired.'
            ];
        }

        // Check usage limit
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return [
                'valid' => false,
                'message' => 'This coupon has reached its usage limit.'
            ];
        }

        // Check per user limit
        if ($userId && $this->per_user_limit) {
            $userUsageCount = $this->usages()->where('user_id', $userId)->count();
            if ($userUsageCount >= $this->per_user_limit) {
                return [
                    'valid' => false,
                    'message' => 'You have reached the usage limit for this coupon.'
                ];
            }
        }

        // Check minimum order amount
        if ($this->min_order_amount && $cartTotal < $this->min_order_amount) {
            return [
                'valid' => false,
                'message' => 'Minimum order amount of ₹' . number_format($this->min_order_amount, 0) . ' required.'
            ];
        }

        return [
            'valid' => true,
            'message' => 'Coupon is valid.'
        ];
    }

    public function calculateDiscount($cartTotal)
    {
        if ($this->type === 'percentage') {
            $discount = ($cartTotal * $this->value) / 100;
            
            // Apply max discount cap if set
            if ($this->max_discount) {
                $discount = min($discount, $this->max_discount);
            }
            
            return $discount;
        } else {
            return $this->value;
        }
    }
}
