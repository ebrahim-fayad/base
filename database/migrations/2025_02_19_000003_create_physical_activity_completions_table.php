<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * جدول تسجيل إكمال المستخدم للنشاط البدني: اليوزر X خلص النشاط Y وجاب فيه Z نقطة.
     */
    public function up(): void
    {
        Schema::create('physical_activity_completions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('level_id')->constrained('levels')->cascadeOnDelete();
            $table->foreignId('level_day_id')->constrained('level_days')->cascadeOnDelete();
            $table->foreignId('daily_activity_id')->constrained('daily_activities')->cascadeOnDelete();
            $table->unsignedInteger('rate')->default(0)->comment('النسبة اللي جابها من النشاط ده');
            $table->timestamps();

            $table->unique(
                ['user_id', 'level_id', 'level_day_id', 'daily_activity_id'],
                'physical_activity_completions_user_level_day_activity_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('physical_activity_completions');
    }
};
