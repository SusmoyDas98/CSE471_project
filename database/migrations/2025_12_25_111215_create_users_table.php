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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('email', 100)->unique();
            $table->string('google_id')->nullable();
            $table->longText('google_token')->nullable();
            $table->longText('google_refresh_token')->nullable();
            $table->string('password')->nullable();
            $table->enum('role', ['Dorm Seeker', 'Dorm Owner', 'Admin'])->nullable();
            $table->enum('subscription_type', ['Free', 'Premium'])
                  ->default('Free');
            $table->date('subscription_exp')->nullable();

            $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
=======
return new class extends Migration {
    public function up(): void {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['Dorm Seeker','Dorm Owner']);
            $table->enum('subscription_type', ['Free','Paid'])->default('Free');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('users');
    }
};

>>>>>>> afia-branch
