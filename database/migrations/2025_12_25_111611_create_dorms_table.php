<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('dorms', function (Blueprint $table) {
            $table->id();
            $table->integer("dorm_id")->unique();
            $table->string('name');
            $table->string('location');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->integer('number_of_rooms')->nullable();
            $table->enum("gender", ["Male", "Female", "Not Gender Specified"])->default("Not Gender Specified");
            $table->enum("student_only", ["Yes", "No"])->nullable()->default("No");
            $table->enum("expected_matrimonial_status", ["Married", "Unmarried", "Not Specified"])->default("Not Specified");
            $table->text("facilities")->nullable();
            $table->text('room_types')->nullable();
            $table->string('owner_passport')->nullable();
            $table->string('property_document')->nullable();
            $table->text('dorm_images')->nullable();
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('dorms');
    }
};
