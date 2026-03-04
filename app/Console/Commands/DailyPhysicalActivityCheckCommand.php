<?php

namespace App\Console\Commands;

use App\Enums\IncentivePointType;
use App\Models\IncentivePoint;
use App\Models\Programs\Exercise;
use App\Models\Programs\PhysicalActivityCompletion;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * يشغّل في نهاية كل يوم (23:59).
 * من لم يكمل الأربعة تمارين في نفس اليوم: حذف إكمالاته من physical_activity_completions
 * وحذف نقاط التحفيز (type=1) الخاصة بذلك اليوم من incentive_points.
 */
class DailyPhysicalActivityCheckCommand extends Command
{
    protected $signature = 'daily:physical-activity-check';

    protected $description = 'Rollback incomplete daily physical activity completions and their incentive points (runs at 23:59).';

    public function handle(): int
    {
        $startOfDay = Carbon::today();
        $endOfDay   = Carbon::today()->endOfDay();

        $groups = PhysicalActivityCompletion::query()
            ->whereBetween('created_at', [$startOfDay, $endOfDay])
            ->select(['user_id', 'level_id', 'level_day_id'])
            ->selectRaw('COUNT(*) as cnt')
            ->groupBy('user_id', 'level_id', 'level_day_id')
            ->havingRaw('COUNT(*) > 0 AND COUNT(*) < ?', [Exercise::MAX_EXERCISES_PER_DAY])
            ->get();

        $rolled = 0;
        foreach ($groups as $group) {
            DB::transaction(function () use ($group, $startOfDay, $endOfDay, &$rolled) {
                $deleted = PhysicalActivityCompletion::query()
                    ->where('user_id', $group->user_id)
                    ->where('level_id', $group->level_id)
                    ->where('level_day_id', $group->level_day_id)
                    ->delete();
                if ($deleted > 0) {
                    // حذف نقاط التحفيز (type=1) اللي created_at بتاعها النهارده لنفس المستخدم
                    IncentivePoint::query()
                        ->where('user_id', $group->user_id)
                        ->where('type', IncentivePointType::PhysicalActivity->value)
                        ->whereBetween('created_at', [$startOfDay, $endOfDay])
                        ->delete();
                    $rolled++;
                }
            });
        }

        $this->info("Daily physical activity check done. Rolled back {$rolled} incomplete day(s).");
        return self::SUCCESS;
    }
}
