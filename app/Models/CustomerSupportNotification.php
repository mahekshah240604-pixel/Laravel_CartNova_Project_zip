<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerSupportNotification extends Model
{
    use HasFactory;

    protected $table = 'customer_support_notifications';

    protected $fillable = [
        'user_id',
        'customer_support_id',
        'type',
        'title',
        'message',
        'is_read',
        'read_at',
        'data',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'data' => 'array',
    ];

    // Auto include attributes in JSON/UI
    protected $appends = ['time_ago', 'icon', 'color'];

    // ================= RELATIONSHIPS =================

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function customerSupport(): BelongsTo
    {
        return $this->belongsTo(CustomerSupport::class);
    }

    // ================= HELPER METHODS =================

    public function markAsRead(): bool
    {
        return $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    public function markAsUnread(): bool
    {
        return $this->update([
            'is_read' => false,
            'read_at' => null,
        ]);
    }

    // ================= ATTRIBUTES =================

    public function getFormattedCreatedAtAttribute(): string
    {
        return $this->created_at 
            ? $this->created_at->format('M j, Y \a\t g:i A') 
            : '';
    }

    public function getTimeAgoAttribute(): string
    {
        return $this->created_at 
            ? $this->created_at->diffForHumans() 
            : '';
    }

    public function getIconAttribute(): string
    {
        return match($this->type) {
            'ticket_created' => '🎫',
            'ticket_updated' => '✏️',
            'ticket_closed' => '✅',
            'admin_response' => '💬',
            default => '🔔'
        };
    }

    public function getColorAttribute(): string
    {
        return match($this->type) {
            'ticket_created' => '#FF9900',
            'ticket_updated' => '#007bff',
            'ticket_closed' => '#28a745',
            'admin_response' => '#17a2b8',
            default => '#6c757d'
        };
    }

    // ================= SCOPES =================

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // ================= STATIC METHODS =================

    public static function createNotification(
        $userId,
        $customerSupportId,
        $type,
        $title,
        $message,
        $data = null
    ) {
        return self::create([
            'user_id' => $userId,
            'customer_support_id' => $customerSupportId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data ?? [],
        ]);
    }

    public static function getUnreadCount($userId): int
    {
        return self::forUser($userId)->unread()->count();
    }

    public static function markAllAsRead($userId): int
    {
        return self::forUser($userId)->unread()->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }
}