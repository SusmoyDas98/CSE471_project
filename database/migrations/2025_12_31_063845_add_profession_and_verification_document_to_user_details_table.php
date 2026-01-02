<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user_details', function (Blueprint $table) {
            $table->string('profession', 20)->nullable()->after('bio');
            $table->string('verification_document')->nullable()->after('profession');
            $table->dropColumn(['student_verification_document', 'nid_document']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_details', function (Blueprint $table) {
            $table->string('student_verification_document')->nullable();
            $table->string('nid_document')->nullable();
            $table->dropColumn(['profession', 'verification_document']);
        });
    }
};
