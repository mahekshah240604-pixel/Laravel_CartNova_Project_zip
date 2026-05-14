<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('notifications')) {
            Schema::create('notifications', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('type');          // order_placed, order_shipped, order_delivered, order_cancelled, coupon, system
                $table->string('title');
                $table->text('body');
                $table->string('icon')->default('🔔');
                $table->string('url')->nullable(); // link to related page
                $table->boolean('is_read')->default(false);
                $table->json('data')->nullable();  // extra data (order_id etc.)
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};