<?php
// app/Models/Notification.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'type', 'title', 'body',
        'icon', 'url', 'is_read', 'data',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'data'    => 'array',
    ];

    // ── Relationships ─────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ── Helpers ───────────────────────────────────
    public function getTimeAgoAttribute(): string
    {
        $diff = now()->diff($this->created_at);
        if ($diff->days > 6)  return $this->created_at->format('d M Y');
        if ($diff->days >= 1) return $diff->days . 'd ago';
        if ($diff->h >= 1)    return $diff->h . 'h ago';
        if ($diff->i >= 1)    return $diff->i . 'm ago';
        return 'Just now';
    }

    // ── Static factory methods ────────────────────
    public static function send(int $userId, string $type, string $title, string $body, string $url = null, string $icon = null, array $data = []): self
    {
        $icons = [
            'order_placed'    => '🛒',
            'order_confirmed' => '✅',
            'order_shipped'   => '🚚',
            'order_delivered' => '🏠',
            'order_cancelled' => '❌',
            'coupon'          => '🎟️',
            'review'          => '⭐',
            'wishlist'        => '❤️',
            'system'          => '🔔',
            'payment'         => '💳',
        ];

        return self::create([
            'user_id' => $userId,
            'type'    => $type,
            'title'   => $title,
            'body'    => $body,
            'icon'    => $icon ?? ($icons[$type] ?? '🔔'),
            'url'     => $url,
            'is_read' => false,
            'data'    => $data,
        ]);
    }

    // ── Scope: unread ─────────────────────────────
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }
}