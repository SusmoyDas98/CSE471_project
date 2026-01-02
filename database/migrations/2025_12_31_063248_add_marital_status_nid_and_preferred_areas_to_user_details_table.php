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
            $table->string('marital_status', 20)->nullable()->after('gender_pref');
            $table->string('nid_document')->nullable()->after('student_verification_document');
            $table->json('preferred_areas')->nullable()->after('preferred_universities');
            $table->dropColumn('preferred_universities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_details', function (Blueprint $table) {
            $table->json('preferred_universities')->nullable();
            $table->dropColumn(['marital_status', 'nid_document', 'preferred_areas']);
        });
    }
};
