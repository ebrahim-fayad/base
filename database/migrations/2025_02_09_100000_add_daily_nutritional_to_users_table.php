<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('daily_calories')->nullable()->after('waist_circumference')->comment('السعرات الحرارية اليومية');
            $table->unsignedInteger('daily_protein')->nullable()->after('daily_calories')->comment('البروتين اليومي (جرام)');
            $table->unsignedInteger('daily_carbohydrates')->nullable()->after('daily_protein')->comment('الكربوهيدرات اليومية (جرام)');
            $table->unsignedInteger('daily_fats')->nullable()->after('daily_carbohydrates')->comment('الدهون اليومية (جرام)');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['daily_calories', 'daily_protein', 'daily_carbohydrates', 'daily_fats']);
        });
    }
};
