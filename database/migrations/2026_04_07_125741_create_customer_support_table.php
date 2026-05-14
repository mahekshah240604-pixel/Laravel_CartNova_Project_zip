<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customer_support', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Ticket information
            $table->string('ticket_number', 20)->unique(); // Unique ticket number
            $table->string('subject');
            $table->text('message');
            $table->text('admin_response')->nullable();
            
            // Category and priority
            $table->enum('category', ['order_issue', 'payment_problem', 'product_inquiry', 'account_help', 'technical_support', 'refund_request', 'general_feedback', 'complaint', 'other']);
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            
            // Status tracking
            $table->enum('status', ['open', 'in_progress', 'pending_customer', 'resolved', 'closed'])->default('open');
            $table->timestamp('opened_at')->nullable();
            $table->timestamp('first_response_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            
            // User preferences
            $table->boolean('email_notifications')->default(true);
            $table->string('contact_preference')->default('email'); // email, phone, both
            
            // Order/Transaction reference (optional)
            $table->string('order_number')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('product_id')->nullable();
            
            // Attachments and media
            $table->json('attachments')->nullable(); // Store file paths
            
            // Satisfaction and feedback
            $table->tinyInteger('satisfaction_rating')->nullable(); // 1-5 stars
            $table->text('feedback_comments')->nullable();
            
            // Internal notes
            $table->text('internal_notes')->nullable(); // Admin-only notes
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null'); // Admin assigned
            
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['user_id', 'status']);
            $table->index(['ticket_number']);
            $table->index(['category']);
            $table->index(['priority']);
            $table->index(['status', 'opened_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_support');
    }
};
