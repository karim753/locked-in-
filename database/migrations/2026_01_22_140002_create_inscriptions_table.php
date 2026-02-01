<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('keuzdeel_id')->constrained('keuzedelen')->onDelete('cascade');
            $table->enum('status', ['pending', 'confirmed', 'waitlist', 'cancelled'])->default('pending');
            $table->integer('priority')->default(1);
            $table->timestamp('inscribed_at')->useCurrent();
            $table->timestamps();
            
            $table->unique(['user_id', 'keuzdeel_id']);
            $table->index(['user_id', 'status']);
            $table->index(['keuzdeel_id', 'status']);
            $table->index('inscribed_at');
            $table->index('priority');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inscriptions');
    }
};
