<?php
// database/migrations/2024_01_01_000005_create_orders_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('order_number')->unique();
                $table->string('status')->default('pending'); // pending, confirmed, shipped, delivered, cancelled
                // Shipping Address
                $table->string('full_name');
                $table->string('phone');
                $table->string('address_line1');
                $table->string('address_line2')->nullable();
                $table->string('city');
                $table->string('state');
                $table->string('pincode');
                // Payment
                $table->string('payment_method')->default('cod'); // cod, card, upi
                $table->string('payment_status')->default('pending'); // pending, paid, failed
                // Amounts
                $table->decimal('subtotal', 10, 2);
                $table->decimal('discount', 10, 2)->default(0);
                $table->decimal('delivery_charge', 10, 2)->default(0);
                $table->decimal('total', 10, 2);
                $table->text('notes')->nullable();
                $table->timestamp('placed_at')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('order_items')) {
            Schema::create('order_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('order_id')->constrained()->onDelete('cascade');
                $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
                $table->string('product_name');
                $table->string('product_brand')->nullable();
                $table->string('product_image')->nullable();
                $table->decimal('price', 10, 2);
                $table->decimal('original_price', 10, 2)->nullable();
                $table->integer('quantity');
                $table->decimal('subtotal', 10, 2);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};