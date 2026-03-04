<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Service for calculating user activity progress and chart data.
 * Uses PhysicalActivityCompletion (rate per daily_activity).
 * Derives activity_order (1-4) from daily_activity position within level_day.
 */
class ActivityProgressService
{
    /** Valid time range options */
    private const VALID_RANGES = ['daily', 'weekly', 'monthly', 'yearly'];

    /**
     * Get progress chart data: average percentage per activity_order (1-4).
     *
     * @param int $userId User ID to filter by
     * @param string $range Time range: daily, weekly, monthly, yearly
     * @return array Array of {activity_order, percentage} objects
     */
    public function getProgressChart(int $userId, string $range): array
    {
        $range = strtolower($range);

        if (!in_array($range, self::VALID_RANGES)) {
            $range = 'daily';
        }

        [$start, $end] = $this->getDateRange($range);

        // activity_order = position of daily_activity within level_day (by id)
        $results = DB::table('physical_activity_completions as pac')
            ->where('pac.user_id', $userId)
            ->whereBetween('pac.created_at', [$start, $end])
            ->selectRaw("
                (SELECT COUNT(*) + 1 FROM daily_activities da2
                 WHERE da2.level_day_id = pac.level_day_id
                 AND da2.id < pac.daily_activity_id
                ) as activity_order,
                AVG(pac.rate) as avg_rate
            ")
            ->groupBy('activity_order')
            ->pluck('avg_rate', 'activity_order')
            ->map(fn (float $avg) => (int) round($avg));

        return $this->formatResponse($results);
    }

    /**
     * Get start and end Carbon instances for the given range.
     *
     * @param string $range daily|weekly|monthly|yearly
     * @return array [Carbon $start, Carbon $end]
     */
    private function getDateRange(string $range): array
    {
        $end = Carbon::now()->endOfDay();
        $start = match ($range) {
            'daily' => Carbon::now()->startOfDay(),
            'weekly' => Carbon::now()->subWeek()->startOfDay(),
            'monthly' => Carbon::now()->subMonth()->startOfDay(),
            'yearly' => Carbon::now()->subYear()->startOfDay(),
            default => Carbon::now()->subWeek()->startOfDay(),
        };

        return [$start, $end];
    }

    /**
     * Ensure all 4 activity_order values exist with default 0 if no data.
     *
     * @param Collection $results Key = activity_order, Value = average percentage
     * @return array
     */
    private function formatResponse(Collection $results): array
    {
        $output = [];

        for ($order = 1; $order <= 4; $order++) {
            $output[] = [
                'activity_order' => $order,
                'percentage' => $results->get($order, 0),
            ];
        }

        return $output;
    }
}
