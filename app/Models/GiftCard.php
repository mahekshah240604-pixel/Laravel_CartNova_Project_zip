<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class GiftCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'card_number',
        'card_code',
        'card_type',
        'card_name',
        'description',
        'initial_value',
        'current_balance',
        'currency',
        'status',
        'expiry_date',
        'activated_at',
        'last_used_at',
        'notes',
        'priority',
        'notify_expiry',
        'notify_low_balance',
        'low_balance_threshold',
        'purchase_source',
        'purchase_date',
        'receipt_number',
    ];

    protected $casts = [
        'initial_value' => 'decimal:2',
        'current_balance' => 'decimal:2',
        'low_balance_threshold' => 'decimal:2',
        'expiry_date' => 'date',
        'activated_at' => 'datetime',
        'last_used_at' => 'datetime',
        'notify_expiry' => 'boolean',
        'notify_low_balance' => 'boolean',
    ];

    /**
     * Get the user that owns the gift card.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get card type options for dropdown.
     */
    public static function getCardTypeOptions(): array
    {
        return [
            'amazon' => 'Amazon Gift Card',
            'flipkart' => 'Flipkart Gift Card',
            'paypal' => 'PayPal Gift Card',
            'google_play' => 'Google Play Gift Card',
            'apple_itunes' => 'Apple iTunes Gift Card',
            'starbucks' => 'Starbucks Gift Card',
            'netflix' => 'Netflix Gift Card',
            'spotify' => 'Spotify Gift Card',
            'custom' => 'Custom Gift Card',
            'other' => 'Other',
        ];
    }

    /**
     * Get status options for dropdown.
     */
    public static function getStatusOptions(): array
    {
        return [
            'active' => 'Active',
            'expired' => 'Expired',
            'used' => 'Used',
            'inactive' => 'Inactive',
        ];
    }

    /**
     * Get priority options for dropdown.
     */
    public static function getPriorityOptions(): array
    {
        return [
            'low' => 'Low Priority',
            'medium' => 'Medium Priority',
            'high' => 'High Priority',
        ];
    }

    /**
     * Get priority color for display.
     */
    public function getPriorityColorAttribute(): string
    {
        return match($this->priority) {
            'high' => '#dc3545', // red
            'medium' => '#ffc107', // yellow
            'low' => '#28a745', // green
            default => '#6c757d', // gray
        };
    }

    /**
     * Get status color for display.
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'active' => '#28a745', // green
            'expired' => '#dc3545', // red
            'used' => '#6c757d', // gray
            'inactive' => '#ffc107', // yellow
            default => '#6c757d', // gray
        };
    }

    /**
     * Check if gift card is expired.
     */
    public function isExpired(): bool
    {
        if (!$this->expiry_date) {
            return false;
        }
        
        return Carbon::parse($this->expiry_date)->isPast();
    }

    /**
     * Check if gift card is expiring soon (within 30 days).
     */
    public function isExpiringSoon(): bool
    {
        if (!$this->expiry_date) {
            return false;
        }
        
        return Carbon::parse($this->expiry_date)->diffInDays(now()) <= 30;
    }

    /**
     * Check if balance is low.
     */
    public function isLowBalance(): bool
    {
        return $this->current_balance <= $this->low_balance_threshold;
    }

    /**
     * Get formatted initial value.
     */
    public function getFormattedInitialValueAttribute(): string
    {
        return $this->currency . ' ' . number_format($this->initial_value, 2);
    }

    /**
     * Get formatted current balance.
     */
    public function getFormattedCurrentBalanceAttribute(): string
    {
        return $this->currency . ' ' . number_format($this->current_balance, 2);
    }

    /**
     * Get formatted expiry date.
     */
    public function getFormattedExpiryDateAttribute(): string
    {
        if (!$this->expiry_date) {
            return 'No expiry';
        }
        
        return Carbon::parse($this->expiry_date)->format('M d, Y');
    }

    /**
     * Get masked card number for display.
     */
    public function getMaskedCardNumberAttribute(): string
    {
        if (strlen($this->card_number) <= 4) {
            return $this->card_number;
        }
        
        return 'XXXX-XXXX-XXXX-' . substr($this->card_number, -4);
    }

    /**
     * Get masked card code for display.
     */
    public function getMaskedCardCodeAttribute(): string
    {
        if (strlen($this->card_code) <= 2) {
            return $this->card_code;
        }
        
        return 'XX' . substr($this->card_code, -2);
    }

    /**
     * Generate unique gift card number.
     */
    public static function generateCardNumber(): string
    {
        do {
            $number = 'GC-' . str_pad(mt_rand(1, 9999999999), 10, '0', STR_PAD_LEFT);
        } while (self::where('card_number', $number)->exists());
        
        return $number;
    }

    /**
     * Generate unique gift card code.
     */
    public static function generateCardCode(): string
    {
        do {
            $code = strtoupper(substr(md5(uniqid()), 0, 10));
        } while (self::where('card_code', $code)->exists());
        
        return $code;
    }

    /**
     * Scope to get active cards.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope to get expired cards.
     */
    public function scopeExpired($query)
    {
        return $query->where('status', 'expired')
                    ->orWhere('expiry_date', '<', now());
    }

    /**
     * Scope to get cards expiring soon.
     */
    public function scopeExpiringSoon($query)
    {
        return $query->where('expiry_date', '<=', now()->addDays(30))
                    ->where('expiry_date', '>', now());
    }

    /**
     * Scope to get low balance cards.
     */
    public function scopeLowBalance($query)
    {
        return $query->whereColumn('current_balance', '<=', 'low_balance_threshold');
    }

    /**
     * Scope to get cards by priority.
     */
    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }
}
