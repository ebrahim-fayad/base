<?php

namespace App\Console\Commands;

use App\Enums\IncentivePointType;
use App\Models\AllUsers\User;
use App\Models\IncentivePoint;
use App\Models\Programs\PhysicalActivityCompletion;
use App\Services\UserMealService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * يشغّل في نهاية كل يوم (23:59).
 * يجمع ماكروز وجبات اليوم ويقارنها بتارجت المستخدم:
 * - عن كل ماكرو (سعرات، بروتين، كارب، دهون) يساوي التارجت: +50 نقطة (نوع DietPlan).
 * - لو ساوى كل الماكروز وأتم الأربعة أنشطة في نفس اليوم: +100 نقطة بونص (نوع BonusDietAndPhysicalActivity).
 */
class DailyMacrosRewardCommand extends Command
{
    protected $signature = 'daily:macros-reward';

    protected $description = 'Award incentive points for daily macro targets and diet+activity bonus (runs at 23:59).';

    public function __construct(
        protected UserMealService $mealService
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $today     = Carbon::today()->toDateString();
        $startDay  = Carbon::today();
        $endDay    = Carbon::today()->endOfDay();

        $usersWithMealsToday = User::query()
            ->whereHas('userMeals', fn ($q) => $q->whereDate('date', $today))
            ->get();

        $awarded = 0;
        foreach ($usersWithMealsToday as $user) {
            $totals    = $this->mealService->getDailyTotals($user->id, $today);
            $matchCount = $this->countMatchingMacros($user, $totals);
            if ($matchCount === 0) {
                continue;
            }

            $pointsToAdd = $matchCount * 50;
            $completedFourActivitiesToday = $this->userCompletedFourActivitiesOnDate($user->id, $startDay, $endDay);
            $this->awardMacroPoints($user->id, $pointsToAdd, $matchCount, $completedFourActivitiesToday);
            $awarded++;
        }

        $this->info("Daily macros reward done. Awarded points for {$awarded} user(s).");
        return self::SUCCESS;
    }

    private function countMatchingMacros(User $user, array $totals): int
    {
        $macros = [
            ['sum' => $totals['total_calories'], 'target' => $user->daily_calories ? (float) $user->daily_calories : null],
            ['sum' => $totals['total_protein'], 'target' => $user->daily_protein ? (float) $user->daily_protein : null],
            ['sum' => $totals['total_carbohydrates'], 'target' => $user->daily_carbohydrates ? (float) $user->daily_carbohydrates : null],
            ['sum' => $totals['total_fats'], 'target' => $user->daily_fats ? (float) $user->daily_fats : null],
        ];
        $matchCount = 0;
        foreach ($macros as $macro) {
            if ($macro['target'] !== null && $macro['target'] > 0
                && (int) round($macro['sum']) === (int) round($macro['target'])) {
                $matchCount++;
            }
        }
        return $matchCount;
    }

    private function awardMacroPoints(int $userId, int $pointsToAdd, int $matchCount, bool $completedFourActivitiesToday): void
    {
        DB::transaction(function () use ($userId, $pointsToAdd, $matchCount, $completedFourActivitiesToday) {
            if ($pointsToAdd > 0) {
                IncentivePoint::create([
                    'user_id'  => $userId,
                    'level_id' => null,
                    'points'   => $pointsToAdd,
                    'type'     => IncentivePointType::DietPlan->value,
                ]);
            }
            if ($matchCount === 4 && $completedFourActivitiesToday) {
                IncentivePoint::create([
                    'user_id'  => $userId,
                    'level_id' => null,
                    'points'   => 100,
                    'type'     => IncentivePointType::BonusDietAndPhysicalActivity->value,
                ]);
            }
        });
    }

    /**
     * هل المستخدم أتم 4 أنشطة بدنية في التاريخ المحدد (أي level_day في ذلك اليوم).
     */
    private function userCompletedFourActivitiesOnDate(int $userId, $startOfDay, $endOfDay): bool
    {
        return PhysicalActivityCompletion::query()
            ->where('user_id', $userId)
            ->whereBetween('created_at', [$startOfDay, $endOfDay])
            ->selectRaw('user_id, level_id, level_day_id, COUNT(*) as cnt')
            ->groupBy('user_id', 'level_id', 'level_day_id')
            ->havingRaw('COUNT(*) >= 4')
            ->exists();
    }
}
