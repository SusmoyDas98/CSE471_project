<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dorm_reviews', function (Blueprint $table) {
            $table->id(); // auto-increment BIGINT (better than int)

            $table->unsignedBigInteger('dorm_id');
            $table->unsignedBigInteger('user_id');

            $table->text('comment_text')->nullable();

            $table->integer('rating')->default(0);

            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dorm_reviews');
    }
};
