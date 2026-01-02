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
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('type'); // card, bank_account, digital_wallet
            $table->string('provider')->nullable(); // stripe, paypal, etc.
            $table->string('last_four')->nullable(); // Last 4 digits of card/account
            $table->string('brand')->nullable(); // Visa, Mastercard, etc.
            $table->boolean('is_default')->default(false);
            $table->json('metadata')->nullable(); // Encrypted payment method details
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
