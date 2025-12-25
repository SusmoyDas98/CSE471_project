<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->foreignId('dorm_id')->nullable()->constrained('dorms')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('user_profile_details');
    }
};
