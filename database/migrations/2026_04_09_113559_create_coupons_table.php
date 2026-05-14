<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('coupons')) {
            Schema::create('coupons', function (Blueprint $table) {
                $table->id();
                $table->string('code')->unique();
                $table->string('description')->nullable();
                $table->enum('type', ['percentage', 'fixed']); // % or flat ₹
                $table->decimal('value', 10, 2);               // discount amount
                $table->decimal('min_order_amount', 10, 2)->default(0); // min cart value
                $table->decimal('max_discount', 10, 2)->nullable();     // cap for % coupons
                $table->integer('usage_limit')->nullable();    // total uses allowed
                $table->integer('used_count')->default(0);     // how many times used
                $table->integer('per_user_limit')->default(1); // uses per user
                $table->boolean('is_active')->default(true);
                $table->timestamp('starts_at')->nullable();
                $table->timestamp('expires_at')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('coupon_usages')) {
            Schema::create('coupon_usages', function (Blueprint $table) {
                $table->id();
                $table->foreignId('coupon_id')->constrained()->onDelete('cascade');
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
                $table->decimal('discount_amount', 10, 2);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('coupon_usages');
        Schema::dropIfExists('coupons');
    }
};