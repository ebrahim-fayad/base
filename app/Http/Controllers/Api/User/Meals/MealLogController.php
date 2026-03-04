<?php

namespace App\Http\Controllers\Api\User\Meals;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Meal\StoreMealRequest;
use App\Http\Requests\Api\User\Meal\UpdateMealRequest;
use App\Http\Resources\Api\User\UserMealResource;
use App\Models\AllUsers\User;
use App\Models\Meals\UserMeal;
use App\Services\UserMealService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MealLogController extends Controller
{
    use ResponseTrait;

    public function __construct(
        protected UserMealService $mealService
    ) {}

    /**
     * قائمة وجبات المستخدم ليوم معين مع الإجمالي اليومي والهدف
     */
    public function index(Request $request): JsonResponse
    {
        $user = auth('user')->user();
        $date = $request->get('date', now()->format('Y-m-d'));

        $meals = UserMeal::where('user_id', $user->id)
            ->whereDate('date', $date)
            ->with(['components.mealItem', 'mealType'])
            ->orderBy('meal_type_id')
            ->get();

        $dailyTotals = $this->mealService->getDailyTotals($user->id, $date);

        $dailyTarget = [
            'calories'      => (float) ($user->daily_calories ?? 0),
            'protein'       => (float) ($user->daily_protein ?? 0),
            'carbohydrates' => (float) ($user->daily_carbohydrates ?? 0),
            'fats'          => (float) ($user->daily_fats ?? 0),
        ];

        return $this->jsonResponse(data: [
            'meals'         => UserMealResource::collection($meals),
            'daily_total'   => $dailyTotals,
            'daily_target'  => $dailyTarget,
        ]);
    }

    /**
     * عرض وجبة واحدة بتفاصيلها
     */
    public function show(int $id): JsonResponse
    {
        $user = auth('user')->user();
        $meal = UserMeal::where('user_id', $user->id)
            ->with(['components.mealItem', 'mealType'])
            ->findOrFail($id);

        return $this->jsonResponse(data: new UserMealResource($meal));
    }

    /**
     * تسجيل وجبة جديدة
     */
    public function store(StoreMealRequest $request): JsonResponse
    {
        $user = auth('user')->user();
        $meal = $this->mealService->createMeal($user->id, $request->validated());

        return $this->jsonResponse(
            msg: __('apis.meal_logged_successfully'),
            data: new UserMealResource($meal)
        );
    }

    /**
     * تحديث وجبة (تعديل المكونات)
     */
    public function update(UpdateMealRequest $request, int $id): JsonResponse
    {
        $user = auth('user')->user();
        $meal = $this->mealService->updateMeal($user->id, $id, $request->validated());

        return $this->jsonResponse(
            msg: __('apis.meal_updated_successfully'),
            data: new UserMealResource($meal)
        );
    }

    /**
     * حذف وجبة
     */
    public function destroy(int $id): JsonResponse
    {
        $user = auth('user')->user();
        $meal = UserMeal::where('user_id', $user->id)->findOrFail($id);
        $meal->delete();

        return $this->jsonResponse(msg: __('apis.meal_deleted_successfully'));
    }
}
