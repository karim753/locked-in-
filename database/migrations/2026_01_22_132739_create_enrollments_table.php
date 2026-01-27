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
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_module_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['pending', 'confirmed', 'rejected', 'waiting_list'])->default('pending');
            $table->integer('preference_order'); // 1 for first choice, 2 for second, etc.
            $table->timestamps();
            
            // Ensure a user can't enroll in the same module multiple times
            $table->unique(['user_id', 'course_module_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
