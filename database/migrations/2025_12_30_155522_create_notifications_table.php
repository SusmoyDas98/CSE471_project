<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id(); // auto-increment primary key

            $table->foreignId('user_id')->constrained()
                  ->onDelete('cascade');

            $table->string('type', 50);
            $table->string('title', 255);
            $table->text('message');

            $table->unsignedBigInteger('related_id')->nullable();

            $table->boolean('is_read')->default(false);

            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
