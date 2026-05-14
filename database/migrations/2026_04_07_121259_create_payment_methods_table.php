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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Payment method type
            $table->enum('type', ['credit_card', 'debit_card', 'paypal', 'upi', 'net_banking', 'wallet'])->default('credit_card');
            
            // Card details (for credit/debit cards)
            $table->string('card_number')->nullable(); // Last 4 digits only
            $table->string('cardholder_name')->nullable();
            $table->string('card_expiry_month')->nullable();
            $table->string('card_expiry_year')->nullable();
            $table->string('card_type')->nullable(); // visa, mastercard, etc.
            
            // PayPal details
            $table->string('paypal_email')->nullable();
            
            // UPI details
            $table->string('upi_id')->nullable();
            
            // Net Banking details
            $table->string('bank_name')->nullable();
            $table->string('bank_account_number')->nullable(); // Last 4 digits only
            
            // Wallet details
            $table->string('wallet_provider')->nullable(); // paytm, phonepe, etc.
            $table->string('wallet_number')->nullable();
            
            // Common fields
            $table->boolean('is_default')->default(false);
            $table->string('nickname')->nullable(); // e.g., "My Personal Card"
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
