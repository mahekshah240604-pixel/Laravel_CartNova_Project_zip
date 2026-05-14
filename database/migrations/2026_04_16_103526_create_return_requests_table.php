<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('return_requests')) {

            Schema::create('return_requests', function (Blueprint $table) {
                $table->id();

                // ✅ Order
                $table->foreignId('order_id')
                      ->constrained('orders')
                      ->onDelete('cascade');

                // ✅ User
                $table->foreignId('user_id')
                      ->constrained('users')
                      ->onDelete('cascade');

                // ✅ Order Item
                $table->foreignId('order_item_id')
                      ->nullable()
                      ->constrained('order_items')
                      ->nullOnDelete();

                $table->string('reason');
                $table->text('message')->nullable();

                $table->enum('status', ['pending', 'approved', 'rejected'])
                      ->default('pending');

                $table->timestamps();
            });

        }
    }

    public function down(): void
    {
        Schema::dropIfExists('return_requests');
    }
};