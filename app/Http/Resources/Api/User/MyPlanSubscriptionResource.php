<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Request;
use App\Enums\DailyStatusEnum;
use App\Models\IncentivePoint;
use App\Models\Programs\Level;
use App\Enums\IncentivePointType;
use App\Models\Programs\Exercise;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Programs\PhysicalActivityCompletion;

class MyPlanSubscriptionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $level = $this->level;
        $totalDays = Level::DURATION_DAYS;
        $completedDays = (int) $this->completed_days;
        $progressPercent = $totalDays > 0
            ? (int) round(($completedDays / $totalDays) * 100)
            : 0;

        return [
            'id' => $this->id,
            'level_id' => $this->level_id,
            'level_number' => $level?->level_number,
            'program_title' => $level?->name,
            'activity_type' => __('apis.activity_type_physical'),
            // أيام التحدي
            'challenge_days' => $totalDays,
            'completed_days' => $completedDays,
            'progress_display' => "{$completedDays}/{$totalDays}",
            // نسبة التقدم (0-100)
            'progress_percentage' => $progressPercent,
            // رسالة التقدم (مثل: نجحت في استكمال 40% من التحدي - استمر في التقدم !)
            'progress_message' => __('apis.my_plan_progress_message', ['percent' => $progressPercent]),
            // النقاط المكتسبة
            'earned_points' => $this->getEarnedPhysicalPoints(),
            // حالة المستوى كاملاً: not_started | in_progress | completed
            // 'level_status' => $this->getLevelStatus($completedDays, $totalDays),
            // حالة اليوم الحالي: حسب تسجيل الأنشطة الأربعة اليومية (مكتمل) أو لا (بروجريس)
            'daily_status' => $this->getDailyStatus(),
        ];
    }

    /**
     * حالة اليوم: حسب عدد إكمالات الأنشطة اللي اتسجلت النهارده (created_at = اليوم) لنفس اليوزر ونفس الليفل.
     * 0 = لم يبدأ، 4 = مكتمل، 1–3 = بروجريس.
     */
    protected function getDailyStatus(): array
    {
        $today = Carbon::today();

        $completedCount = PhysicalActivityCompletion::query()
            ->where('user_id', $this->user_id)
            ->where('level_id', $this->level_id)
            ->whereDate('created_at', $today)
            ->count();

        if ($completedCount >= Exercise::MAX_EXERCISES_PER_DAY) {
            return DailyStatusEnum::getFullObj(DailyStatusEnum::COMPLETED->value, 'dailyStatusEnum');
        }
        if ($completedCount > 0) {
            return DailyStatusEnum::getFullObj(DailyStatusEnum::IN_PROGRESS->value, 'dailyStatusEnum');
        }
        return DailyStatusEnum::getFullObj(DailyStatusEnum::NOT_STARTED->value, 'dailyStatusEnum');
    }

    protected function getLevelStatus(int $completedDays, int $totalDays): array
    {
        if ($completedDays >= $totalDays) {
            return DailyStatusEnum::getFullObj(DailyStatusEnum::COMPLETED->value, 'dailyStatusEnum');
        }
        if ($completedDays > 0) {
            return DailyStatusEnum::getFullObj(DailyStatusEnum::IN_PROGRESS->value, 'dailyStatusEnum');
        }
        return DailyStatusEnum::getFullObj(DailyStatusEnum::NOT_STARTED->value, 'dailyStatusEnum');
    }

    /**
     * Sum of incentive points for this subscription's user+level when type is Physical Activity.
     */
    protected function getEarnedPhysicalPoints(): int
    {
        return (int) IncentivePoint::query()
            ->where('user_id', $this->user_id)
            ->where('level_id', $this->level_id)
            ->where('type', IncentivePointType::PhysicalActivity->value)
            ->sum('points');
    }

}
