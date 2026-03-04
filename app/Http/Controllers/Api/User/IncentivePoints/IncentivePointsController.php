<?php

namespace App\Http\Controllers\Api\User\IncentivePoints;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\User\DailyActivityResource;
use App\Models\Meals\UserMeal;
use App\Models\Programs\Level;
use App\Traits\ResponseTrait;


class IncentivePointsController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        try {
            return $this->jsonResponse(data: [
                'macro_nutrients' => $this->getMacroNutrientsForToday(),
                'daily_activities' => $this->getTodayActivities(),
                'total_achievement_points' => $this->getTotalAchievementPoints(),
                'level_of_commitment' => number_format(($this->getTotalAchievementPoints() / $this->getLevelOfCommitment()) * 100, 2),
            ]);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    private function getTodayActivities()
    {
        $currentSubscription = auth('user')->user()->levelSubscriptions()->with('level', 'level.days')->get()->last();
        $currentDayNumber = $currentSubscription->completed_days + 1;
        $noActiveSubscription = false;
        if ($currentSubscription->completed_days == Level::DURATION_DAYS || !$currentSubscription->active) {
            $noActiveSubscription = true;
            return $this->getTodayActivitiesResponse([], $noActiveSubscription);
        }
        $activities = $currentSubscription->level->days()->where('day_number', $currentDayNumber)->with('exercises')->first()?->exercises;
        return $this->getTodayActivitiesResponse($activities, $noActiveSubscription);
    }

    private function getMacroNutrientsForToday()
    {
        $user = auth('user')->user();
        $userMacrosTarget = [
            'calories' => $user->daily_calories,
            'protein' => $user->daily_protein,
            'carbohydrates' => $user->daily_carbohydrates,
            'fats' => $user->daily_fats,
        ];
        $userMeals = UserMeal::where('user_id', $user->id)->whereDate('date', now()->format('Y-m-d'))->get();
        $userMacrosToday = [
            'calories' => $userMeals->sum('total_calories'),
            'protein' => $userMeals->sum('total_protein'),
            'carbohydrates' => $userMeals->sum('total_carbohydrates'),
            'fats' => $userMeals->sum('total_fats'),
        ];
        return [
            'calories' => [
                'target' => $userMacrosTarget['calories'],
                'today' => $userMacrosToday['calories'],
                'completed' => $userMacrosToday['calories'] == $userMacrosTarget['calories'],
            ],
            'protein' => [
                'target' => $userMacrosTarget['protein'],
                'today' => $userMacrosToday['protein'],
                'completed' => $userMacrosToday['protein'] == $userMacrosTarget['protein'],
            ],
            'carbohydrates' => [
                'target' => $userMacrosTarget['carbohydrates'],
                'today' => $userMacrosToday['carbohydrates'],
                'completed' => $userMacrosToday['carbohydrates'] == $userMacrosTarget['carbohydrates'],
            ],
            'fats' => [
                'target' => $userMacrosTarget['fats'],
                'today' => $userMacrosToday['fats'],
                'completed' => $userMacrosToday['fats'] == $userMacrosTarget['fats'],
            ],
        ];
    }

    private function getTodayActivitiesResponse($activities, $noActiveSubscription)
    {
        return [
            'activities' => DailyActivityResource::collection($activities),
            'no_active_subscription' => $noActiveSubscription,
        ];
    }

    private function getTotalAchievementPoints()
    {
        return (int)auth('user')->user()->incentivePoints()->whereDate('created_at', today())?->sum('points') ?? 0;
    }

    private function getLevelOfCommitment()
    {
        $numberOfMacros = 4;
        $totalPointsForEveryMacro = 50;
        $pointsEarnedByAdheringToTheDietPlan = $numberOfMacros * $totalPointsForEveryMacro;

        $currentSubscription = auth('user')->user()->levelSubscriptions()->with('level', 'level.days')->get()->last();
        if ($currentSubscription->completed_days == Level::DURATION_DAYS || !$currentSubscription->active) {
            return 0;
        }
        $currentDayNumber = $currentSubscription->completed_days + 1;
        $pointsEarnedByAdheringToThePhysicalActivityPlan = $currentSubscription->level->days()->where('day_number', $currentDayNumber)->with('exercises')->first()?->exercises->sum('incentive_points');
        return $pointsEarnedByAdheringToTheDietPlan + $pointsEarnedByAdheringToThePhysicalActivityPlan;
    }
}
