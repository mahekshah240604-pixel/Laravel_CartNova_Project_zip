<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class CustomerSupport extends Model
{
    use HasFactory;

     protected $table = 'customer_support';

    protected $fillable = [
        'user_id',
        'ticket_number',
        'subject',
        'message',
        'admin_response',
        'category',
        'priority',
        'status',
        'opened_at',
        'first_response_at',
        'resolved_at',
        'closed_at',
        'email_notifications',
        'contact_preference',
        'order_number',
        'transaction_id',
        'product_id',
        'attachments',
        'satisfaction_rating',
        'feedback_comments',
        'internal_notes',
        'assigned_to',
    ];

    protected $casts = [
        'attachments' => 'array',
        'satisfaction_rating' => 'integer',
        'email_notifications' => 'boolean',
        'opened_at' => 'datetime',
        'first_response_at' => 'datetime',
        'resolved_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    /**
     * Get the user that owns the support ticket.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin assigned to the ticket.
     */
    public function assignedAdmin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get category options for dropdown.
     */
    public static function getCategoryOptions(): array
    {
        return [
            'order_issue' => 'Order Issue',
            'payment_problem' => 'Payment Problem',
            'product_inquiry' => 'Product Inquiry',
            'account_help' => 'Account Help',
            'technical_support' => 'Technical Support',
            'refund_request' => 'Refund Request',
            'general_feedback' => 'General Feedback',
            'complaint' => 'Complaint',
            'other' => 'Other',
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
            'urgent' => 'Urgent',
        ];
    }

    /**
     * Get status options for dropdown.
     */
    public static function getStatusOptions(): array
    {
        return [
            'open' => 'Open',
            'in_progress' => 'In Progress',
            'pending_customer' => 'Pending Customer Response',
            'resolved' => 'Resolved',
            'closed' => 'Closed',
        ];
    }

    /**
     * Get contact preference options.
     */
    public static function getContactPreferenceOptions(): array
    {
        return [
            'email' => 'Email Only',
            'phone' => 'Phone Only',
            'both' => 'Email & Phone',
        ];
    }

    /**
     * Get priority color for display.
     */
    public function getPriorityColorAttribute(): string
    {
        return match($this->priority) {
            'urgent' => '#dc3545', // red
            'high' => '#fd7e14', // orange
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
            'open' => '#dc3545', // red
            'in_progress' => '#007bff', // blue
            'pending_customer' => '#ffc107', // yellow
            'resolved' => '#28a745', // green
            'closed' => '#6c757d', // gray
            default => '#6c757d', // gray
        };
    }

    /**
     * Get formatted ticket number.
     */
    public function getFormattedTicketNumberAttribute(): string
    {
        return 'CS-' . str_pad($this->ticket_number, 8, '0', STR_PAD_LEFT);
    }

    /**
     * Get formatted opened date.
     */
    public function getFormattedOpenedAtAttribute(): string
    {
        return $this->opened_at ? $this->opened_at->format('M d, Y h:i A') : 'N/A';
    }

    /**
     * Get formatted response time.
     */
    public function getResponseTimeAttribute(): string
    {
        if (!$this->first_response_at || !$this->opened_at) {
            return 'N/A';
        }
        
        $diff = $this->opened_at->diffInHours($this->first_response_at);
        
        if ($diff < 1) {
            return 'Less than 1 hour';
        } elseif ($diff < 24) {
            return $diff . ' hours';
        } else {
            return floor($diff / 24) . ' days';
        }
    }

    /**
     * Check if ticket is resolved.
     */
    public function isResolved(): bool
    {
        return in_array($this->status, ['resolved', 'closed']);
    }

    /**
     * Check if ticket is waiting for customer response.
     */
    public function isPendingCustomer(): bool
    {
        return $this->status === 'pending_customer';
    }

    /**
     * Check if ticket is active (not closed).
     */
    public function isActive(): bool
    {
        return !in_array($this->status, ['resolved', 'closed']);
    }

    /**
     * Get satisfaction rating display.
     */
    public function getSatisfactionDisplayAttribute(): string
    {
        if (!$this->satisfaction_rating) {
            return 'Not Rated';
        }
        
        return str_repeat(' ', $this->satisfaction_rating) . $this->satisfaction_rating . '/5';
    }

    /**
     * Generate unique ticket number.
     */
    public static function generateTicketNumber(): string
    {
        do {
            $number = str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);
        } while (self::where('ticket_number', $number)->exists());
        
        return $number;
    }

    /**
     * Scope to get open tickets.
     */
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    /**
     * Scope to get active tickets.
     */
    public function scopeActive($query)
    {
        return $query->whereNotIn('status', ['resolved', 'closed']);
    }

    /**
     * Scope to get tickets by priority.
     */
    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    /**
     * Scope to get tickets by category.
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope to get tickets assigned to admin.
     */
    public function scopeAssignedTo($query, $adminId)
    {
        return $query->where('assigned_to', $adminId);
    }

    /**
     * Scope to get unassigned tickets.
     */
    public function scopeUnassigned($query)
    {
        return $query->whereNull('assigned_to');
    }
}
