<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_meals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('meal_type_id')->constrained('meal_types')->cascadeOnDelete();
            $table->date('date')->comment('تاريخ الوجبة');
            $table->decimal('total_calories', 12, 2)->default(0);
            $table->decimal('total_protein', 12, 2)->default(0);
            $table->decimal('total_carbohydrates', 12, 2)->default(0);
            $table->decimal('total_fats', 12, 2)->default(0);
            $table->timestamps();

            $table->unique(['user_id', 'meal_type_id', 'date'], 'user_meal_type_date_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_meals');
    }
};
