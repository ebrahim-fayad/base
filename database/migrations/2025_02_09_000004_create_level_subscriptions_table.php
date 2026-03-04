<?php

/**
 * Creates `level_subscriptions` table (user subscription per level).
 * Filename kept for migration history compatibility.
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('level_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('level_id')->constrained()->cascadeOnDelete();
            $table->boolean('active')->default(true);
            $table->unsignedInteger('completed_days')->default(0);
            $table->unsignedInteger('incomplete_days')->default(30);
            $table->unsignedInteger('extra_days')->default(0);
            $table->date('last_completed_day_date')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'level_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('level_subscriptions');
    }
};
