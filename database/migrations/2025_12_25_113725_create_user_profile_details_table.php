<?php
<<<<<<< HEAD

=======
>>>>>>> afia-branch
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

<<<<<<< HEAD
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_profile_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->integer('age')->nullable();

            $table->enum('gender', ['Male', 'Female'])->nullable();
            $table->string('contact_number')->nullable();
            $table->json('preferences')->nullable();
            $table->json('hobbies')->nullable();
            $table->enum("student", ["Yes", "No"])->nullable()->default("No");
            $table->string('profession')->nullable();
            $table->string('marital_status', 50)->nullable();
=======
return new class extends Migration {
    public function up(): void {
        Schema::create('user_profile_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('age')->nullable();
            $table->enum('gender', ['Male','Female','Other'])->nullable();
            $table->text('preferences')->nullable();
            $table->string('study_level')->nullable();
            $table->text('hobbies')->nullable();
>>>>>>> afia-branch
            $table->foreignId('dorm_id')->nullable()->constrained('dorms')->onDelete('set null');
            $table->timestamps();
        });
    }

<<<<<<< HEAD
    public function down(): void
    {
=======
    public function down(): void {
>>>>>>> afia-branch
        Schema::dropIfExists('user_profile_details');
    }
};
