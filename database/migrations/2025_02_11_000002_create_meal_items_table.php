<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meal_items', function (Blueprint $table) {
            $table->id();
            $table->json('name')->nullable();
            $table->decimal('calories', 10, 2)->default(0)->comment('لكل 100 جرام');
            $table->decimal('protein', 10, 2)->default(0)->comment('لكل 100 جرام');
            $table->decimal('carbohydrates', 10, 2)->default(0)->comment('لكل 100 جرام');
            $table->decimal('fats', 10, 2)->default(0)->comment('لكل 100 جرام');
            $table->boolean('active')->default(true);
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meal_items');
    }
};
