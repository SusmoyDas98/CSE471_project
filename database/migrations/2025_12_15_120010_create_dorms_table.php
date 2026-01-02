<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dorms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('city', 120)->nullable();
            $table->string('nearby_university', 160)->nullable();
            $table->text('description')->nullable();
            $table->json('amenities')->nullable();
            $table->json('rules')->nullable();
            $table->json('photos')->nullable();
            $table->string('contact_phone', 50)->nullable();
            $table->string('contact_email', 120)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dorms');
    }
};

