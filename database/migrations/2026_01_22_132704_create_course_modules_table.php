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
        Schema::create('course_modules', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('title');
            $table->text('description');
            $table->text('learning_goals');
            $table->text('content');
            $table->integer('minimum_students')->default(15);
            $table->integer('maximum_students')->default(30);
            $table->boolean('allow_multiple_enrollments')->default(false);
            $table->boolean('is_active')->default(true);
            $table->string('period'); // e.g., '2024-2025-P1'
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_modules');
    }
};
