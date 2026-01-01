<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('dorm_registration_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('dorm_owner_name');
            $table->foreignId('owner_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('dorm_hotline');
            $table->string('dorm_name');
            $table->string('dorm_location');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->integer('number_of_rooms')->nullable();
            $table->enum('gender_preference', ['Male', 'Female', 'Not Gender Specified']);
            $table->text('facilities')->nullable();
            $table->text('room_types')->nullable();
            $table->string('student_only')->nullable();
            $table->string("expected_marital_status");
            $table->string('owner_national_id')->nullable();
            $table->string('passport')->nullable();
            $table->text('property_ownership_doc')->nullable();
            $table->text('dorm_pictures')->nullable();
            $table->text('status')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('dorm_registration_submissions');
    }
};