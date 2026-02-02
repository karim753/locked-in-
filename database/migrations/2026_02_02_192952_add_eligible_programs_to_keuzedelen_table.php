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
        Schema::table('keuzedelen', function (Blueprint $table) {
            $table->json('eligible_programs')->nullable()->after('credits');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('keuzedelen', function (Blueprint $table) {
            $table->dropColumn('eligible_programs');
        });
    }
};
