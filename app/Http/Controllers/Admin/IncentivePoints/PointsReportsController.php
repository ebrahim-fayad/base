<?php

namespace App\Http\Controllers\Admin\IncentivePoints;

use Carbon\Carbon;
use App\Enums\IncentivePointType;
use App\Models\IncentivePoint;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * تقارير النقاط التحفيزية: مجموع النقاط (يومي/أسبوعي/شهري)، أكثر المستخدمين حصولاً على نقاط،
 * مستوى النشاط، ومقارنة بين فترات زمنية.
 */
class PointsReportsController extends Controller
{
    public function index(Request $request)
    {
        $dateFrom = $request->get('date_from') ? Carbon::parse($request->date_from)->startOfDay() : Carbon::now()->subDays(30)->startOfDay();
        $dateTo = $request->get('date_to') ? Carbon::parse($request->date_to)->endOfDay() : Carbon::now()->endOfDay();
        $period = $request->get('period', 'daily'); // daily | weekly | monthly

        $report = $this->getReportData($dateFrom, $dateTo, $period);
        $comparison = $this->getPeriodComparison($dateFrom, $dateTo);

        return view('admin.incentive-points.reports.index', get_defined_vars());
    }

    public function exportPdf(Request $request)
    {
        $dateFrom = $request->get('date_from') ? Carbon::parse($request->date_from)->startOfDay() : Carbon::now()->subDays(30)->startOfDay();
        $dateTo = $request->get('date_to') ? Carbon::parse($request->date_to)->endOfDay() : Carbon::now()->endOfDay();
        $period = $request->get('period', 'daily');

        $report = $this->getReportData($dateFrom, $dateTo, $period);
        $comparison = $this->getPeriodComparison($dateFrom, $dateTo);

        $data = array_merge($report, [
            'comparison' => $comparison,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'period' => $period,
        ]);
        $html = view('admin.incentive-points.reports.export-pdf', $data)->render();
        return $this->downloadPdf($html, 'points-reports-' . Carbon::now()->format('Y-m-d') . '.pdf');
    }

    private function getReportData(Carbon $dateFrom, Carbon $dateTo, string $period): array
    {
        $baseQuery = IncentivePoint::query()
            ->where('created_at', '>=', $dateFrom)
            ->where('created_at', '<=', $dateTo);

        $totalPoints = (clone $baseQuery)->sum('points');
        $totalRecords = (clone $baseQuery)->count();
        $activeUsersCount = (int) (clone $baseQuery)->selectRaw('COUNT(DISTINCT user_id) as c')->value('c');

        // تجميع النقاط حسب الفترة (يومي / أسبوعي / شهري)
        $pointsByPeriod = $this->getPointsAggregatedByPeriod($dateFrom, $dateTo, $period);

        // النقاط حسب النوع
        $byType = [];
        foreach (IncentivePointType::cases() as $type) {
            $q = IncentivePoint::where('type', $type)
                ->where('created_at', '>=', $dateFrom)
                ->where('created_at', '<=', $dateTo);
            $byType[] = [
                'type' => $type,
                'label' => $type->label(),
                'count' => $q->count(),
                'points' => (clone $q)->sum('points'),
            ];
        }

        // أكثر المستخدمين حصولاً على نقاط
        $topUsers = IncentivePoint::query()
            ->select('user_id', DB::raw('SUM(points) as total_points'), DB::raw('COUNT(*) as records_count'))
            ->where('created_at', '>=', $dateFrom)
            ->where('created_at', '<=', $dateTo)
            ->groupBy('user_id')
            ->orderByDesc('total_points')
            ->limit(20)
            ->with('user:id,name,phone')
            ->get();

        // عينة من سجل النقاط
        $pointsList = IncentivePoint::with(['user:id,name,phone', 'level:id,name'])
            ->where('created_at', '>=', $dateFrom)
            ->where('created_at', '<=', $dateTo)
            ->orderByDesc('created_at')
            ->limit(50)
            ->get();

        return [
            'totalPoints' => $totalPoints,
            'totalRecords' => $totalRecords,
            'activeUsersCount' => $activeUsersCount,
            'pointsByPeriod' => $pointsByPeriod,
            'byType' => $byType,
            'topUsers' => $topUsers,
            'pointsList' => $pointsList,
            'period' => $period,
        ];
    }

    private function getPointsAggregatedByPeriod(Carbon $dateFrom, Carbon $dateTo, string $period): array
    {
        $dateColumn = match ($period) {
            'weekly' => DB::raw("DATE_FORMAT(created_at, '%Y-%u') as period_key"),
            'monthly' => DB::raw("DATE_FORMAT(created_at, '%Y-%m') as period_key"),
            default => DB::raw('DATE(created_at) as period_key'),
        };

        return IncentivePoint::query()
            ->select($dateColumn, DB::raw('SUM(points) as points'), DB::raw('COUNT(*) as records'))
            ->where('created_at', '>=', $dateFrom)
            ->where('created_at', '<=', $dateTo)
            ->groupBy('period_key')
            ->orderBy('period_key')
            ->get()
            ->toArray();
    }

    /**
     * مقارنة الفترة الحالية مع الفترة السابقة (نفس الطول).
     */
    private function getPeriodComparison(Carbon $dateFrom, Carbon $dateTo): array
    {
        $days = $dateFrom->diffInDays($dateTo) ?: 1;
        $prevFrom = $dateFrom->copy()->subDays($days);
        $prevTo = $dateFrom->copy()->subSecond();

        $currentPoints = IncentivePoint::query()
            ->where('created_at', '>=', $dateFrom)
            ->where('created_at', '<=', $dateTo)
            ->sum('points');

        $previousPoints = IncentivePoint::query()
            ->where('created_at', '>=', $prevFrom)
            ->where('created_at', '<=', $prevTo)
            ->sum('points');

        $currentUsers = (int) IncentivePoint::query()
            ->where('created_at', '>=', $dateFrom)
            ->where('created_at', '<=', $dateTo)
            ->selectRaw('COUNT(DISTINCT user_id) as c')
            ->value('c');

        $previousUsers = (int) IncentivePoint::query()
            ->where('created_at', '>=', $prevFrom)
            ->where('created_at', '<=', $prevTo)
            ->selectRaw('COUNT(DISTINCT user_id) as c')
            ->value('c');

        $pointsChange = $this->percentChange($currentPoints, $previousPoints);
        $usersChange = $this->percentChange($currentUsers, $previousUsers);

        return [
            'current_points' => $currentPoints,
            'previous_points' => $previousPoints,
            'points_change_percent' => $pointsChange,
            'current_users' => $currentUsers,
            'previous_users' => $previousUsers,
            'users_change_percent' => $usersChange,
            'previous_from' => $prevFrom,
            'previous_to' => $prevTo,
        ];
    }

    private function percentChange(int $current, int $previous): float
    {
        if ($previous > 0) {
            return round((($current - $previous) / $previous) * 100, 1);
        }
        return $current > 0 ? 100.0 : 0.0;
    }

    private function downloadPdf(string $html, string $filename)
    {
        $html = trim($html);
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font' => 'dejavusans',
            'default_font_size' => 11,
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 8,
            'margin_bottom' => 8,
            'margin_header' => 0,
            'margin_footer' => 0,
        ]);
        $mpdf->WriteHTML($html);
        return response()->streamDownload(function () use ($mpdf) {
            echo $mpdf->Output('', 'S');
        }, $filename, ['Content-Type' => 'application/pdf']);
    }
}
