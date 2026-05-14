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
        Schema::create('customer_support_notifications', function (Blueprint $table) {
            $table->id();

            // User relation
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Customer support relation (FIXED ✅)
            $table->foreignId('customer_support_id')
                  ->constrained('customer_support') // correct table
                  ->onDelete('cascade');

            // Notification details
            $table->enum('type', [ // better than string ✅
                'ticket_created',
                'ticket_updated',
                'ticket_closed',
                'admin_response'
            ]);

            $table->string('title');
            $table->text('message');

            // Status
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();

            // Extra data
            $table->json('data')->nullable();

            $table->timestamps();

            // Indexes
            $table->index(['user_id', 'is_read']);
            $table->index(['customer_support_id']);
            $table->index(['type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_support_notifications');
    }
};
