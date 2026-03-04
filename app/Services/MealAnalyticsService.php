<?php

namespace App\Services;

use App\Models\AllUsers\User;
use App\Models\Meals\MealItem;
use Illuminate\Support\Facades\DB;
use App\Models\Meals\UserMeal;
use App\Models\Meals\UserMealComponent;
use Illuminate\Support\Collection;

class MealAnalyticsService
{
    /**
     * أكثر الأصناف استخداماً من قبل المستخدمين (مرتبة تنازلياً)
     */
    public function getMostUsedMealItems(int $limit = 20): Collection
    {
        return UserMealComponent::query()
            ->selectRaw('meal_item_id, COUNT(*) as usage_count, SUM(quantity_grams) as total_grams')
            ->groupBy('meal_item_id')
            ->orderByDesc('usage_count')
            ->limit($limit)
            ->get()
            ->map(function ($row) {
                $mealItem = MealItem::withTrashed()->find($row->meal_item_id);
                return [
                    'meal_item_id'   => $row->meal_item_id,
                    'name'           => $mealItem?->name ?? __('admin.deleted'),
                    'usage_count'    => (int) $row->usage_count,
                    'total_grams'    => (float) $row->total_grams,
                ];
            });
    }

    /**
     * متوسط السعرات اليومية المحسوبة للمستخدمين
     * لكل مستخدم: مجموع سعرات وجباته / عدد الأيام التي سجّل فيها
     */
    public function getAverageDailyCaloriesByUsers(): Collection
    {
        $userIds = UserMeal::distinct()->pluck('user_id');
        $users = User::whereIn('id', $userIds)->get()->keyBy('id');

        return UserMeal::query()
            ->selectRaw('
                user_id,
                COUNT(DISTINCT date) as days_logged,
                COUNT(*) as meals_count,
                SUM(total_calories) as total_calories,
                AVG(total_calories) as avg_per_meal
            ')
            ->groupBy('user_id')
            ->get()
            ->map(function ($row) use ($users) {
                $user = $users->get($row->user_id);
                $avgDaily = $row->days_logged > 0
                    ? round($row->total_calories / $row->days_logged, 2)
                    : 0;
                return [
                    'user_id'       => $row->user_id,
                    'user_name'     => $user?->name ?? '-',
                    'user_phone'    => $user ? ($user->country_code . $user->phone) : '-',
                    'days_logged'   => (int) $row->days_logged,
                    'meals_count'   => (int) $row->meals_count,
                    'total_calories' => (float) $row->total_calories,
                    'avg_daily_calories' => (float) $avgDaily,
                    'avg_per_meal'  => (float) $row->avg_per_meal,
                ];
            })
            ->sortByDesc('avg_daily_calories')
            ->values();
    }

    /**
     * إحصائيات عامة
     */
    public function getGeneralStats(): array
    {
        $totalMeals = UserMeal::count();
        $totalComponents = UserMealComponent::count();
        $usersWithMeals = UserMeal::distinct('user_id')->count('user_id');

        $caloriesStats = UserMeal::selectRaw('
            COALESCE(SUM(total_calories), 0) as total,
            COALESCE(AVG(total_calories), 0) as avg_per_meal
        ')->first();

        $driver = DB::getDriverName();
        $totalUserDays = match ($driver) {
            'mysql' => (int) (UserMeal::selectRaw('COUNT(DISTINCT CONCAT(user_id, "-", date)) as c')->value('c') ?? 0),
            default => UserMeal::select('user_id', 'date')->distinct()->get()->count(),
        };

        $avgDailyOverall = $totalUserDays > 0
            ? round($caloriesStats->total / $totalUserDays, 2)
            : 0;

        return [
            'total_meals_logged'    => $totalMeals,
            'total_components'      => $totalComponents,
            'users_with_meals'      => $usersWithMeals,
            'total_calories_logged' => (float) $caloriesStats->total,
            'avg_calories_per_meal' => (float) $caloriesStats->avg_per_meal,
            'avg_daily_calories_overall' => (float) $avgDailyOverall,
        ];
    }
}
