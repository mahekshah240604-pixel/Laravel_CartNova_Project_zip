<?php
// app/Models/Address.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','full_name','phone',
        'address_line1','address_line2',
        'city','state','pincode',
        'type','is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    // ── Relationships ─────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ── Helpers ───────────────────────────────────
    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            $this->address_line1,
            $this->address_line2,
            $this->city,
            $this->state . ' - ' . $this->pincode,
        ]);
        return implode(', ', $parts);
    }

    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'home'  => '🏠 Home',
            'work'  => '💼 Work',
            default => '📍 Other',
        };
    }
}