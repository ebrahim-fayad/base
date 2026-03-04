<?php

namespace App\Http\Controllers\Admin\MealItems;

use App\Http\Controllers\Controller;
use App\Services\MealAnalyticsService;
use Illuminate\View\View;

class MealAnalyticsController extends Controller
{
    public function __construct(
        protected MealAnalyticsService $analyticsService
    ) {}

    public function index(): View
    {
        $generalStats = $this->analyticsService->getGeneralStats();
        $mostUsedItems = $this->analyticsService->getMostUsedMealItems(30);
        $avgCaloriesByUsers = $this->analyticsService->getAverageDailyCaloriesByUsers();

        return view('admin.meal_analytics.index', [
            'generalStats'      => $generalStats,
            'mostUsedItems'     => $mostUsedItems,
            'avgCaloriesByUsers' => $avgCaloriesByUsers,
        ]);
    }
}
