<?php
// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'category', 'brand',
        'price', 'original_price', 'discount', 'image',
        'stock', 'rating', 'reviews_count', 'is_prime', 'is_featured',
         'user_id',
    ];

    protected $casts = [
        'price'          => 'decimal:2',
        'original_price' => 'decimal:2',
        'rating'         => 'decimal:1',
        'is_prime'       => 'boolean',
        'is_featured'    => 'boolean',
    ];

    // ── Scopes ────────────────────────────────────────────────
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    // ── Helpers ───────────────────────────────────────────────
    public function getFormattedPriceAttribute()
    {
        return '₹' . number_format($this->price, 0, '.', ',');
    }

    public function getFormattedOriginalPriceAttribute()
    {
        return $this->original_price
            ? '₹' . number_format($this->original_price, 0, '.', ',')
            : null;
    }

    public function getStarRatingAttribute()
    {
        return str_repeat('★', floor($this->rating))
             . str_repeat('☆', 5 - floor($this->rating));
    }
}