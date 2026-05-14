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
        Schema::create('gift_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Gift card details
            $table->string('card_number', 20)->unique(); // Unique gift card number
            $table->string('card_code', 10)->unique(); // 10-digit activation code
            $table->string('card_type'); // amazon, flipkart, paypal, custom, etc.
            $table->string('card_name'); // e.g., "Amazon Gift Card"
            $table->text('description')->nullable(); // Card description or message
            
            // Value and balance
            $table->decimal('initial_value', 10, 2); // Original value
            $table->decimal('current_balance', 10, 2); // Current balance
            $table->string('currency', 3)->default('USD'); // Currency code
            
            // Status and dates
            $table->enum('status', ['active', 'expired', 'used', 'inactive'])->default('active');
            $table->date('expiry_date')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->timestamp('last_used_at')->nullable();
            
            // User preferences
            $table->string('notes')->nullable(); // User can add notes
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->boolean('notify_expiry')->default(true);
            $table->boolean('notify_low_balance')->default(true);
            $table->decimal('low_balance_threshold', 10, 2)->default(10.00);
            
            // Purchase/receipt information
            $table->string('purchase_source')->nullable(); // Where it was purchased
            $table->date('purchase_date')->nullable();
            $table->string('receipt_number')->nullable();
            
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['user_id', 'status']);
            $table->index(['expiry_date']);
            $table->index(['card_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gift_cards');
    }
};
