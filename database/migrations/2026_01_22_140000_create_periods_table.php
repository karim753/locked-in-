<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('periods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamp('enrollment_opens_at');
            $table->timestamp('enrollment_closes_at');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['start_date', 'end_date']);
            $table->index(['enrollment_opens_at', 'enrollment_closes_at']);
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('periods');
    }
};
