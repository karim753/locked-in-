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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['student', 'admin', 'slber'])->default('student')->after('email');
            $table->string('study_program')->nullable()->after('role');
            $table->string('microsoft_id')->unique()->nullable()->after('id');
            
            $table->index('microsoft_id');
            $table->index('role');
            $table->index('study_program');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['microsoft_id']);
            $table->dropIndex(['role']);
            $table->dropIndex(['study_program']);
            $table->dropColumn(['role', 'study_program', 'microsoft_id']);
        });
    }
};
