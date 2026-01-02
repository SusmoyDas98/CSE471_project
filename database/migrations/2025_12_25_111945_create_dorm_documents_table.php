<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('dorm_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dorm_registration_id')
                  ->nullable()
                  ->constrained('dorm_registration_submissions')
                  ->onDelete('cascade');
            $table->foreignId('dorm_id')
                  ->nullable()
                  ->constrained('dorms')
                  ->onDelete('cascade');
            $table->string('owner_passport')->nullable();
            $table->string('property_document')->nullable();
            $table->text('dorm_images')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('dorm_documents');
    }
};
