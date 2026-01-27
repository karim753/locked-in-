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
        Schema::create('completed_keuzedelen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('keuzdeel_id')->constrained()->onDelete('cascade');
            $table->date('completion_date');
            $table->string('grade')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'keuzdeel_id']);
            $table->index(['user_id', 'completion_date']);
            $table->index(['keuzdeel_id', 'completion_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('completed_keuzedelen');
    }
};
