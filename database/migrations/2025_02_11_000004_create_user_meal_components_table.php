<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_meal_components', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_meal_id')->constrained('user_meals')->cascadeOnDelete();
            $table->foreignId('meal_item_id')->constrained('meal_items')->cascadeOnDelete();
            $table->decimal('quantity_grams', 10, 2)->comment('الكمية بالجرام');
            $table->decimal('calculated_calories', 12, 2)->default(0);
            $table->decimal('calculated_protein', 12, 2)->default(0);
            $table->decimal('calculated_carbohydrates', 12, 2)->default(0);
            $table->decimal('calculated_fats', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_meal_components');
    }
};
