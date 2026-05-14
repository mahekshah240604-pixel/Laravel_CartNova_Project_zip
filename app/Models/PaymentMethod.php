<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'card_number',
        'cardholder_name',
        'card_expiry_month',
        'card_expiry_year',
        'card_type',
        'paypal_email',
        'upi_id',
        'bank_name',
        'bank_account_number',
        'wallet_provider',
        'wallet_number',
        'is_default',
        'nickname',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    /**
     * Get the user that owns the payment method.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the display name for the payment method.
     */
    public function getDisplayNameAttribute(): string
    {
        switch ($this->type) {
            case 'credit_card':
            case 'debit_card':
                $cardNumber = '**** **** **** ' . $this->card_number;
                $cardType = ucfirst($this->card_type ?? 'Card');
                return "{$cardType} ending in {$this->card_number}";
            
            case 'paypal':
                return "PayPal - {$this->paypal_email}";
            
            case 'upi':
                return "UPI - {$this->upi_id}";
            
            case 'net_banking':
                return "Net Banking - {$this->bank_name}";
            
            case 'wallet':
                return ucfirst($this->wallet_provider) . " - {$this->wallet_number}";
            
            default:
                return ucfirst(str_replace('_', ' ', $this->type));
        }
    }

    /**
     * Get payment method types for dropdown.
     */
    public static function getPaymentTypes(): array
    {
        return [
            'credit_card' => 'Credit Card',
            'debit_card' => 'Debit Card',
            'paypal' => 'PayPal',
            'upi' => 'UPI',
            'net_banking' => 'Net Banking',
            'wallet' => 'Mobile Wallet',
        ];
    }

    /**
     * Get wallet providers for dropdown.
     */
    public static function getWalletProviders(): array
    {
        return [
            'paytm' => 'PayTM',
            'phonepe' => 'PhonePe',
            'googlepay' => 'Google Pay',
            'amazonpay' => 'Amazon Pay',
            'mobikwik' => 'MobiKwik',
        ];
    }

    /**
     * Get card types for dropdown.
     */
    public static function getCardTypes(): array
    {
        return [
            'visa' => 'Visa',
            'mastercard' => 'Mastercard',
            'amex' => 'American Express',
            'discover' => 'Discover',
            'rupay' => 'RuPay',
        ];
    }

    /**
     * Mask sensitive card number.
     */
    public static function maskCardNumber(string $cardNumber): string
    {
        $cardNumber = preg_replace('/\D/', '', $cardNumber);
        $length = strlen($cardNumber);
        
        if ($length >= 4) {
            return '**** **** **** ' . substr($cardNumber, -4);
        }
        
        return $cardNumber;
    }

    /**
     * Validate card expiry.
     */
    public function isExpired(): bool
    {
        if (!$this->card_expiry_month || !$this->card_expiry_year) {
            return false;
        }

        $expiryMonth = (int) $this->card_expiry_month;
        $expiryYear = (int) $this->card_expiry_year;
        
        $currentMonth = (int) date('m');
        $currentYear = (int) date('Y');
        
        return ($expiryYear < $currentYear) || 
               ($expiryYear == $currentYear && $expiryMonth < $currentMonth);
    }

    /**
     * Set this as default payment method and unset others.
     */
    public function setAsDefault(): void
    {
        // Unset all other payment methods for this user
        static::where('user_id', $this->user_id)
              ->where('id', '!=', $this->id)
              ->update(['is_default' => false]);
        
        // Set this as default
        $this->update(['is_default' => true]);
    }
}
