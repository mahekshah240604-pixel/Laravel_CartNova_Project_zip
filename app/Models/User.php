<?php
// app/Models/User.php

namespace App\Models;
use App\Models\Address;
use App\Models\Order;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// ✅ NOTE: HasApiTokens (Laravel Sanctum) removed.
// It caused a red underline because Laravel\Sanctum is NOT installed by default.
// If you need API token auth later, run:
//   composer require laravel/sanctum
//   php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
//   php artisan migrate
// Then add back: use Laravel\Sanctum\HasApiTokens;
//           and: use HasApiTokens, HasFactory, Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    // ✅ Only built-in Laravel traits — no extra package needed
    use HasFactory, Notifiable;

    /**
     * Mass-assignable fields.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Hidden from serialization (JSON / array).
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Attribute casts.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    // ✅ ADD THIS
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function orders()
{
    return $this->hasMany(Order::class);
}
}