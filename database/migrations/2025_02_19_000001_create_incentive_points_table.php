<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations. Creates incentive_points table for user-earned points by type.
     */
    public function up(): void
    {
        Schema::create('incentive_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedInteger('points')->default(0);
            $table->unsignedTinyInteger('type')->index();
            $table->foreignId('level_id')->nullable()->constrained('levels')->nullOnDelete();
            $table->timestamps();

            $table->index(['user_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incentive_points');
    }
};
