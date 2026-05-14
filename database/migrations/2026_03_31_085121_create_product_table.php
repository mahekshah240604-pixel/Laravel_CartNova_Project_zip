<?php
// database/migrations/2024_01_01_000002_create_products_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('description')->nullable();
                $table->string('category');
                $table->string('brand')->nullable();
                $table->decimal('price', 10, 2);
                $table->decimal('original_price', 10, 2)->nullable();
                $table->integer('discount')->default(0); // percentage
                $table->string('image')->nullable();
                $table->integer('stock')->default(0);
                $table->decimal('rating', 2, 1)->default(0);
                $table->integer('reviews_count')->default(0);
                $table->boolean('is_prime')->default(false);
                $table->boolean('is_featured')->default(false);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};