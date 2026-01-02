<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dorm_id')->constrained()->cascadeOnDelete();
            $table->string('label');
            $table->unsignedTinyInteger('capacity')->default(1);
            $table->unsignedInteger('price')->nullable();
            $table->string('room_type', 50)->nullable();
            $table->boolean('is_shared')->default(false);
            $table->unsignedInteger('size_sqft')->nullable();
            $table->string('gender_policy', 30)->nullable();
            $table->date('available_from')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};

