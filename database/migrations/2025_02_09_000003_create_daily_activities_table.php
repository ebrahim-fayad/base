<?php

/**
 * Creates `daily_activities` table (exercises per day, max 4 per level_day).
 * Filename kept for migration history compatibility.
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('level_day_id')->constrained()->cascadeOnDelete();
            $table->json('exercise_name')->nullable();
            $table->json('description')->nullable();
            $table->string('image', 100)->nullable();
            $table->unsignedInteger('incentive_points')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_activities');
    }
};
