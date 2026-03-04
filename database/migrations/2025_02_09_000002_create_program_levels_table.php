<?php

/**
 * Creates `level_days` table (30 days per level).
 * Filename kept for migration history compatibility.
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('level_days', function (Blueprint $table) {
            $table->id();
            $table->foreignId('level_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('day_number')->comment('1-30');
            $table->unique(['level_id', 'day_number']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('level_days');
    }
};
