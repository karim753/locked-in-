<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keuzedelen', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('period_id')->constrained()->onDelete('cascade');
            $table->integer('min_participants')->default(15);
            $table->integer('max_participants')->default(30);
            $table->boolean('is_repeatable')->default(false);
            $table->boolean('is_active')->default(true);
            $table->string('teacher_name')->nullable();
            $table->text('schedule_info')->nullable();
            $table->integer('credits')->default(1);
            $table->timestamps();
            
            $table->index('period_id');
            $table->index('is_active');
            $table->index('is_repeatable');
            $table->index(['min_participants', 'max_participants']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keuzedelen');
    }
};
