<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('website_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('message')->nullable();
            $table->integer('rating')->nullable()->check('rating BETWEEN 1 AND 5');
            $table->string('label')->nullable();
            $table->timestamp('label_markerd_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('website_reviews');
    }};

// <<<<<<< HEAD
// <<<<<<< HEAD
// <<<<<<< HEAD
// };
// =======
// };
// >>>>>>> d81146069f60673832c6b342aacee5197e68c42b
// =======
// };
// >>>>>>> afia-branch
// =======
// };
// >>>>>>> 21fbe592305037f082c2083091047c60be3e64d2
