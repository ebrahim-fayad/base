<?php

namespace App\Services;

use App\Models\Meals\MealItem;
use App\Models\Meals\MealType;
use App\Models\Meals\UserMeal;
use App\Models\Meals\UserMealComponent;
use App\Services\Core\BaseService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class UserMealService extends BaseService
{
    public function __construct()
    {
        $this->model = UserMeal::class;
    }

    /**
     * حساب القيم الغذائية بناءً على الكمية (القيم المدخلة لكل 100 جرام)
     */
    public function calculateNutritionalValues(MealItem $mealItem, float $quantityGrams): array
    {
        $multiplier = $quantityGrams / 100;
        return [
            'calculated_calories'      => round((float) $mealItem->calories * $multiplier, 2),
            'calculated_protein'       => round((float) $mealItem->protein * $multiplier, 2),
            'calculated_carbohydrates' => round((float) $mealItem->carbohydrates * $multiplier, 2),
            'calculated_fats'          => round((float) $mealItem->fats * $multiplier, 2),
        ];
    }

    /**
     * إنشاء وجبة جديدة مع المكونات
     */
    public function createMeal(int $userId, array $data): UserMeal
    {
        return DB::transaction(function () use ($userId, $data) {
            $date = Carbon::parse($data['date'])->format('Y-m-d');

            // التحقق من أن نوع الوجبة نشط
            MealType::where('id', $data['meal_type_id'])->where('active', true)->firstOrFail();

            // التحقق من عدم وجود نفس نوع الوجبة في نفس اليوم
            $exists = UserMeal::where('user_id', $userId)
                ->where('meal_type_id', $data['meal_type_id'])
                ->whereDate('date', $date)
                ->exists();

            if ($exists) {
                throw ValidationException::withMessages([
                    'meal_type_id' => [__('apis.meal_type_already_logged_today')],
                ]);
            }

            $totalCalories = 0;
            $totalProtein = 0;
            $totalCarbs = 0;
            $totalFats = 0;

            $userMeal = UserMeal::create([
                'user_id'               => $userId,
                'meal_type_id'          => $data['meal_type_id'],
                'date'                  => $date,
                'total_calories'        => 0,
                'total_protein'         => 0,
                'total_carbohydrates'   => 0,
                'total_fats'            => 0,
            ]);

            foreach ($data['components'] as $component) {
                $mealItem = MealItem::where('id', $component['meal_item_id'])
                    ->where('active', true)
                    ->firstOrFail();

                $calculated = $this->calculateNutritionalValues($mealItem, (float) $component['quantity_grams']);

                UserMealComponent::create([
                    'user_meal_id'             => $userMeal->id,
                    'meal_item_id'             => $mealItem->id,
                    'quantity_grams'           => $component['quantity_grams'],
                    'calculated_calories'      => $calculated['calculated_calories'],
                    'calculated_protein'       => $calculated['calculated_protein'],
                    'calculated_carbohydrates' => $calculated['calculated_carbohydrates'],
                    'calculated_fats'          => $calculated['calculated_fats'],
                ]);

                $totalCalories += $calculated['calculated_calories'];
                $totalProtein += $calculated['calculated_protein'];
                $totalCarbs += $calculated['calculated_carbohydrates'];
                $totalFats += $calculated['calculated_fats'];
            }

            $userMeal->update([
                'total_calories'      => round($totalCalories, 2),
                'total_protein'       => round($totalProtein, 2),
                'total_carbohydrates' => round($totalCarbs, 2),
                'total_fats'          => round($totalFats, 2),
            ]);

            return $userMeal->fresh(['components.mealItem', 'mealType']);
        });
    }

    /**
     * تحديث وجبة (إضافة/تعديل/حذف مكونات) وإعادة حساب الإجماليات
     */
    public function updateMeal(int $userId, int $mealId, array $data): UserMeal
    {
        return DB::transaction(function () use ($userId, $mealId, $data) {
            $userMeal = UserMeal::where('user_id', $userId)->findOrFail($mealId);

            // حذف المكونات الحالية وإضافة الجديدة
            $userMeal->components()->delete();

            $totalCalories = 0;
            $totalProtein = 0;
            $totalCarbs = 0;
            $totalFats = 0;

            foreach ($data['components'] as $component) {
                $mealItem = MealItem::where('id', $component['meal_item_id'])
                    ->where('active', true)
                    ->firstOrFail();

                $calculated = $this->calculateNutritionalValues($mealItem, (float) $component['quantity_grams']);

                UserMealComponent::create([
                    'user_meal_id'             => $userMeal->id,
                    'meal_item_id'             => $mealItem->id,
                    'quantity_grams'           => $component['quantity_grams'],
                    'calculated_calories'      => $calculated['calculated_calories'],
                    'calculated_protein'       => $calculated['calculated_protein'],
                    'calculated_carbohydrates' => $calculated['calculated_carbohydrates'],
                    'calculated_fats'          => $calculated['calculated_fats'],
                ]);

                $totalCalories += $calculated['calculated_calories'];
                $totalProtein += $calculated['calculated_protein'];
                $totalCarbs += $calculated['calculated_carbohydrates'];
                $totalFats += $calculated['calculated_fats'];
            }

            $userMeal->update([
                'total_calories'      => round($totalCalories, 2),
                'total_protein'       => round($totalProtein, 2),
                'total_carbohydrates' => round($totalCarbs, 2),
                'total_fats'          => round($totalFats, 2),
            ]);

            return $userMeal->fresh(['components.mealItem', 'mealType']);
        });
    }

    /**
     * إجمالي الاستهلاك اليومي للمستخدم في تاريخ معين
     */
    public function getDailyTotals(int $userId, string $date): array
    {
        $totals = UserMeal::where('user_id', $userId)
            ->whereDate('date', $date)
            ->selectRaw('
                COALESCE(SUM(total_calories), 0) as total_calories,
                COALESCE(SUM(total_protein), 0) as total_protein,
                COALESCE(SUM(total_carbohydrates), 0) as total_carbohydrates,
                COALESCE(SUM(total_fats), 0) as total_fats
            ')
            ->first();

        return [
            'total_calories'      => (float) $totals->total_calories,
            'total_protein'       => (float) $totals->total_protein,
            'total_carbohydrates' => (float) $totals->total_carbohydrates,
            'total_fats'          => (float) $totals->total_fats,
        ];
    }
}
