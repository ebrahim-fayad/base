<?php

namespace App\Http\Controllers\Admin\Analytics;

use Carbon\Carbon;
use App\Enums\IncentivePointType;
use App\Models\AllUsers\User;
use App\Models\IncentivePoint;
use App\Models\Programs\Level;
use App\Models\Programs\LevelSubscription;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    /**
     * التقارير والإحصاءات العامة - صفحة رئيسية تعرض تقارير المستخدمين والاشتراكات والنقاط
     */
    public function index(Request $request)
    {
        $dateFrom = $request->get('date_from') ? Carbon::parse($request->date_from)->startOfDay() : null;
        $dateTo = $request->get('date_to') ? Carbon::parse($request->date_to)->endOfDay() : null;

        // تقرير المستخدمين (نشطين / غير نشطين)
        $usersReport = $this->getUsersReportData($dateFrom, $dateTo);

        // تقرير الاشتراكات داخل البرامج
        $subscriptionsReport = $this->getSubscriptionsReportData($dateFrom, $dateTo);

        // تقرير النقاط والتحفيز
        $pointsReport = $this->getPointsReportData($dateFrom, $dateTo);

        return view('admin.analytics.index', get_defined_vars());
    }

    /**
     * تصدير تقرير المستخدمين PDF
     */
    public function exportUsersPdf(Request $request)
    {
        $dateFrom = $request->get('date_from') ? Carbon::parse($request->date_from)->startOfDay() : null;
        $dateTo = $request->get('date_to') ? Carbon::parse($request->date_to)->endOfDay() : null;
        $data = $this->getUsersReportData($dateFrom, $dateTo);
        $html = view('admin.export.analytics-users-pdf', $data)->render();
        return $this->downloadPdf($html, 'users-report-' . Carbon::now()->format('Y-m-d') . '.pdf');
    }

    /**
     * تصدير تقرير الاشتراكات PDF
     */
    public function exportSubscriptionsPdf(Request $request)
    {
        $dateFrom = $request->get('date_from') ? Carbon::parse($request->date_from)->startOfDay() : null;
        $dateTo = $request->get('date_to') ? Carbon::parse($request->date_to)->endOfDay() : null;
        $data = $this->getSubscriptionsReportData($dateFrom, $dateTo);
        $html = view('admin.export.analytics-subscriptions-pdf', $data)->render();
        return $this->downloadPdf($html, 'subscriptions-report-' . Carbon::now()->format('Y-m-d') . '.pdf');
    }

    /**
     * تصدير تقرير النقاط والتحفيز PDF
     */
    public function exportPointsPdf(Request $request)
    {
        $dateFrom = $request->get('date_from') ? Carbon::parse($request->date_from)->startOfDay() : null;
        $dateTo = $request->get('date_to') ? Carbon::parse($request->date_to)->endOfDay() : null;
        $data = $this->getPointsReportData($dateFrom, $dateTo);
        $html = view('admin.export.analytics-points-pdf', $data)->render();
        return $this->downloadPdf($html, 'points-report-' . Carbon::now()->format('Y-m-d') . '.pdf');
    }

    private function getUsersReportData(?Carbon $dateFrom, ?Carbon $dateTo): array
    {
        $usersQuery = User::query();
        if ($dateFrom) {
            $usersQuery->where('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $usersQuery->where('created_at', '<=', $dateTo);
        }

        $activeQuery = clone $usersQuery;
        $inactiveQuery = clone $usersQuery;

        $totalUsers = (clone $usersQuery)->count();
        $activeUsers = $activeQuery->where('active', true)->count();
        $inactiveUsers = $inactiveQuery->where('active', false)->count();

        // قائمة عينة للمستخدمين (للعرض في الصفحة - آخر 50)
        $usersList = User::query()
            ->select('id', 'name', 'phone', 'country_code', 'active', 'created_at')
            ->when($dateFrom, fn ($q) => $q->where('created_at', '>=', $dateFrom))
            ->when($dateTo, fn ($q) => $q->where('created_at', '<=', $dateTo))
            ->orderByDesc('created_at')
            ->limit(100)
            ->get();

        return [
            'totalUsers' => $totalUsers,
            'activeUsers' => $activeUsers,
            'inactiveUsers' => $inactiveUsers,
            'usersList' => $usersList,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
        ];
    }

    private function getSubscriptionsReportData(?Carbon $dateFrom, ?Carbon $dateTo): array
    {
        $subsQuery = LevelSubscription::with(['user:id,name,phone', 'level:id,name']);
        if ($dateFrom) {
            $subsQuery->where('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $subsQuery->where('created_at', '<=', $dateTo);
        }

        $totalSubscriptions = (clone $subsQuery)->count();
        $activeSubscriptions = (clone $subsQuery)->active()->count();

        $byProgram = Level::withTrashed()->withCount(['subscriptions' => function ($q) use ($dateFrom, $dateTo) {
            if ($dateFrom) {
                $q->where('level_subscriptions.created_at', '>=', $dateFrom);
            }
            if ($dateTo) {
                $q->where('level_subscriptions.created_at', '<=', $dateTo);
            }
        }])->get()->map(fn ($level) => [
            'name' => $level->name,
            'count' => $level->subscriptions_count ?? 0,
        ])->toArray();

        $subscriptionsList = LevelSubscription::with(['user:id,name,phone', 'level:id,name'])
            ->when($dateFrom, fn ($q) => $q->where('level_subscriptions.created_at', '>=', $dateFrom))
            ->when($dateTo, fn ($q) => $q->where('level_subscriptions.created_at', '<=', $dateTo))
            ->orderByDesc('level_subscriptions.created_at')
            ->limit(100)
            ->get();

        return [
            'totalSubscriptions' => $totalSubscriptions,
            'activeSubscriptions' => $activeSubscriptions,
            'byProgram' => $byProgram,
            'subscriptionsList' => $subscriptionsList,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
        ];
    }

    private function getPointsReportData(?Carbon $dateFrom, ?Carbon $dateTo): array
    {
        $pointsQuery = IncentivePoint::with(['user:id,name,phone', 'level:id,name']);
        if ($dateFrom) {
            $pointsQuery->where('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $pointsQuery->where('created_at', '<=', $dateTo);
        }

        $totalPoints = (clone $pointsQuery)->sum('points');
        $totalRecords = (clone $pointsQuery)->count();

        $byType = [];
        foreach (IncentivePointType::cases() as $type) {
            $q = IncentivePoint::where('type', $type);
            if ($dateFrom) {
                $q->where('created_at', '>=', $dateFrom);
            }
            if ($dateTo) {
                $q->where('created_at', '<=', $dateTo);
            }
            $byType[] = [
                'type' => $type,
                'label' => $type->label(),
                'count' => $q->count(),
                'points' => (clone $q)->sum('points'),
            ];
        }

        $pointsList = IncentivePoint::with(['user:id,name,phone', 'level:id,name'])
            ->when($dateFrom, fn ($q) => $q->where('created_at', '>=', $dateFrom))
            ->when($dateTo, fn ($q) => $q->where('created_at', '<=', $dateTo))
            ->orderByDesc('created_at')
            ->limit(100)
            ->get();

        return [
            'totalPoints' => $totalPoints,
            'totalRecords' => $totalRecords,
            'byType' => $byType,
            'pointsList' => $pointsList,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
        ];
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
