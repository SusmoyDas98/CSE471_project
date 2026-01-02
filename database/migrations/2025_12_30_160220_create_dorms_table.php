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

            $table->foreignId('owner_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->string('name', 100);

            $table->string('location')->nullable();

            // ✅ ADDED FIELDS (after location)
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->enum('student_only', ['Yes', 'No'])
                  ->nullable()
                  ->default('No');
            $table->string('owner_passport')->nullable();
            $table->string('property_document')->nullable();
            $table->text('dorm_images')->nullable();

            $table->integer('number_of_rooms')->nullable();
            $table->string('room_types')->nullable();

            $table->enum('status', ['Pending', 'Approved', 'Declined'])
                  ->default('Pending');

            $table->text('dorm_review')->nullable();
            $table->decimal('dorm_rating', 3, 2)->default(0.00);

            $table->string('gender_preference', 20)->nullable();
            $table->decimal('rent', 10, 2)->default(0.00);

            $table->text('facilities')->nullable();
            $table->string('expected_marital_status', 50)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dorm');
    }
};
