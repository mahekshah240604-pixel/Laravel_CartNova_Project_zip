<?php
// app/Models/Review.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'product_id', 'rating',
        'title', 'body', 'helpful_count', 'verified_purchase',
    ];

    protected $casts = [
        'verified_purchase' => 'boolean',
    ];

    // ── Relationships ─────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // ── Helpers ───────────────────────────────────
    public function getStarsAttribute()
    {
        return str_repeat('★', $this->rating)
             . str_repeat('☆', 5 - $this->rating);
    }

    public function getStarColorAttribute()
    {
        return match(true) {
            $this->rating >= 4 => '#FF9900',
            $this->rating == 3 => '#FF9900',
            default            => '#CC0C39',
        };
    }
}