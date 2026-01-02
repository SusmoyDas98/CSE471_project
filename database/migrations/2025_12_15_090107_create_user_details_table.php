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
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('phone')->nullable();
            $table->text('bio')->nullable();
            $table->unsignedInteger('budget_min')->nullable();
            $table->unsignedInteger('budget_max')->nullable();
            $table->date('move_in_date')->nullable();
            $table->unsignedTinyInteger('stay_length_months')->nullable();
            $table->string('room_type_pref', 50)->nullable();
            $table->string('gender_pref', 20)->nullable();
            $table->boolean('smoking')->default(false);
            $table->boolean('pet_friendly')->default(false);
            $table->unsignedTinyInteger('cleanliness_level')->nullable();
            $table->unsignedTinyInteger('noise_tolerance')->nullable();
            $table->time('wake_time')->nullable();
            $table->time('sleep_time')->nullable();
            $table->string('study_habits', 100)->nullable();
            $table->json('languages')->nullable();
            $table->json('interests')->nullable();
            $table->string('location_priority', 120)->nullable();
            $table->json('amenities_priority')->nullable();
            $table->boolean('has_roommate')->default(false);
            $table->unsignedTinyInteger('roommate_count')->nullable();
            $table->json('preferred_universities')->nullable();
            $table->timestamps();
            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};
