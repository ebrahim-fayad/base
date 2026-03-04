<?php

/**
 * Creates `levels` table (current structure: level = 30 days, 4 exercises/day).
 * Filename kept for migration history compatibility.
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('levels', function (Blueprint $table) {
            $table->id();
            $table->json('name')->nullable();
            $table->json('description')->nullable();
            $table->decimal('subscription_price', 10, 2)->default(0);
            $table->boolean('active')->default(true);
            $table->unsignedSmallInteger('order')->default(1);
            $table->string('level_number')->nullable()->comment('رقم المستوى كنص مثل: الاول، الثاني');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('levels');
    }
};
