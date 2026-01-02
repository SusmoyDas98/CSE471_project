<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dorm_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dorm_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamp('joined_at')->nullable();
            $table->timestamps();
            $table->unique(['dorm_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dorm_user');
    }
};

