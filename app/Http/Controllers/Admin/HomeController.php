<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Exports\DashboardExport;
use App\Models\AllUsers\User;
use App\Models\CountryCity\Country;
use App\Models\Programs\Level;
use App\Models\Programs\LevelSubscription;
use App\Traits\MenuTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\Admin\Auth\UpdatePassword;
use App\Http\Requests\Admin\AllUsers\Admin\UpdateProfile;

class HomeController extends Controller
{
    use MenuTrait ;

    /***************** dashboard *****************/
    public function dashboard()
    {
        $countryArray = $this->chartData(new Country);
        $revenuesArray = $this->getRevenuesData();
        $profitsData = $this->getProfitsData();
        $menus = $this->home();
        $colors = ['info', 'danger', 'warning', 'success', 'primary'];

        // Engagement indicators
        $engagementStats = $this->getEngagementStats();
        $subscriptionRatesByProgram = $this->getSubscriptionRatesByProgram();
        $usersChartData = $this->getUsersChartData();

        return view('admin.dashboard.index', get_defined_vars());
    }

    /**
     * Export dashboard report as Excel
     */
    public function exportExcel()
    {
        $stats = [
            'registered_users' => User::count(),
            'active_users' => User::where('active', true)->count(),
            'programs_count' => Level::count(),
            'total_subscriptions' => LevelSubscription::count(),
            'subscription_rate' => User::count() > 0
                ? round((LevelSubscription::count() / User::count()) * 100, 1)
                : 0,
        ];
        $engagementStats = $this->getEngagementStats();
        $subscriptionRatesByProgram = $this->getSubscriptionRatesByProgram();

        return Excel::download(
            new DashboardExport($stats, $engagementStats, $subscriptionRatesByProgram),
            'dashboard-report-' . Carbon::now()->format('Y-m-d') . '.xlsx'
        );
    }

    /**
     * Export dashboard report as PDF (using mPDF for proper Arabic support)
     */
    public function exportPdf()
    {
        $stats = [
            'registered_users' => User::count(),
            'active_users' => User::where('active', true)->count(),
            'programs_count' => Level::count(),
            'total_subscriptions' => LevelSubscription::count(),
            'subscription_rate' => User::count() > 0
                ? round((LevelSubscription::count() / User::count()) * 100, 1)
                : 0,
        ];
        $engagementStats = $this->getEngagementStats();
        $subscriptionRatesByProgram = $this->getSubscriptionRatesByProgram();

        $html = trim(view('admin.export.dashboard-pdf', compact('stats', 'engagementStats', 'subscriptionRatesByProgram'))->render());

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
        $filename = 'dashboard-report-' . Carbon::now()->format('Y-m-d') . '.pdf';

        return response()->streamDownload(function () use ($mpdf) {
            echo $mpdf->Output('', 'S');
        }, $filename, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    /**
     * Get engagement/commitment indicators
     */
    private function getEngagementStats(): array
    {
        $totalCompletedDays = LevelSubscription::sum('completed_days');
        $totalIncompleteDays = LevelSubscription::sum('incomplete_days');
        $totalDays = $totalCompletedDays + $totalIncompleteDays;
        $complianceRate = $totalDays > 0
            ? round(($totalCompletedDays / $totalDays) * 100, 1)
            : 0;

        return [
            'total_completed_days' => $totalCompletedDays,
            'total_incomplete_days' => $totalIncompleteDays,
            'compliance_rate' => $complianceRate,
            'active_subscriptions' => LevelSubscription::active()->count(),
        ];
    }

    /**
     * Get subscription rates per program
     */
    private function getSubscriptionRatesByProgram(): array
    {
        $programs = Level::withCount('subscriptions')->get();
        $totalUsers = User::count();

        return $programs->map(function ($program) use ($totalUsers) {
            $rate = $totalUsers > 0
                ? round(($program->subscriptions_count / $totalUsers) * 100, 1)
                : 0;
            return [
                'name' => $program->name,
                'subscriptions' => $program->subscriptions_count,
                'rate' => $rate,
            ];
        })->toArray();
    }

    /**
     * Get users registration chart data (last 12 months)
     */
    private function getUsersChartData(): array
    {
        $users = User::select('id', 'created_at')
            ->get()
            ->groupBy(fn ($date) => Carbon::parse($date->created_at)->format('Y-m'));

        $categories = [];
        $data = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i)->format('Y-m');
            $categories[] = Carbon::now()->subMonths($i)->translatedFormat('M');
            $data[] = isset($users[$month]) ? count($users[$month]) : 0;
        }

        return [
            'categories' => $categories,
            'data' => $data,
        ];
    }


    /**
     * Get total revenues data by month
     *
     * @return array
     */
    public function getRevenuesData()
    {
        $revenuesData = [];

        for($i = 1; $i <= 12; $i++) {
            $month = ($i < 10) ? '0'.$i : $i;
            $yearMonth = date('Y').'-'.$month;

            $revenuesData[] = number_format($totalRevenue ?? rand(100, 500), 2);
        }

        return $revenuesData;
    }

    /**
     * Get profits data based on commission_amount in orders
     *
     * @return array
     */
    public function getProfitsData()
    {
        $profitsData = [
            'daily' => $this->getDailyProfits(),
            'weekly' => $this->getWeeklyProfits(),
            'monthly' => $this->getMonthlyProfits(),
            'yearly' => $this->getYearlyProfits(),
        ];

        return $profitsData;
    }

    /**
     * Get daily profits based on commission_amount in orders
     *
     * @return array
     */
    private function getDailyProfits()
    {
        $today = Carbon::today();
        $profits = [];
        $categories = [];

        // Get profits for each 2-hour interval of the current day
        for ($hour = 0; $hour < 24; $hour += 2) {
            $startTime = $today->copy()->addHours($hour);
            $endTime = $today->copy()->addHours($hour + 2);

//            $profit = Order::whereBetween('created_at', [$startTime, $endTime])
//                ->sum('commission_amount') ?? 0;

            $profits[] = number_format($profit ?? rand(50, 100), 2);
            $categories[] = sprintf('%02d:00', $hour);
        }

        return [
            'categories' => $categories,
            'data' => $profits
        ];
    }

    /**
     * Get weekly profits based on commission_amount in orders
     *
     * @return array
     */
    private function getWeeklyProfits()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $profits = [];
        $categories = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        // Get profits for each day of the current week
        for ($day = 0; $day < 7; $day++) {
            $date = $startOfWeek->copy()->addDays($day);

//            $profit = Order::whereDate('created_at', $date)
//                ->sum('commission_amount') ?? 0;

            $profits[] = number_format($profit ?? rand(50, 100), 2);
        }

        return [
            'categories' => $categories,
            'data' => $profits
        ];
    }

    /**
     * Get monthly profits based on commission_amount in orders
     *
     * @return array
     */
    private function getMonthlyProfits()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $daysInMonth = $endOfMonth->day;
        $weeksInMonth = ceil($daysInMonth / 7);

        $profits = [];
        $categories = [];

        // Get profits for each week of the current month
        for ($week = 0; $week < $weeksInMonth; $week++) {
            $startDate = $startOfMonth->copy()->addDays($week * 7);
            $endDate = $startOfMonth->copy()->addDays(($week + 1) * 7 - 1);

            // Ensure end date doesn't exceed the end of month
            if ($endDate->gt($endOfMonth)) {
                $endDate = $endOfMonth->copy();
            }

//            $profit = Order::whereBetween('created_at', [$startDate, $endDate])
//                ->sum('commission_amount') ?? 0;

            $profits[] = number_format($profit ?? rand(100, 500), 2);
            $categories[] = 'Week ' . ($week + 1);
        }

        return [
            'categories' => $categories,
            'data' => $profits
        ];
    }

    /**
     * Get yearly profits based on commission_amount in orders
     *
     * @return array
     */
    private function getYearlyProfits()
    {
        $profits = [];
        $categories = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        // Get profits for each month of the current year
        for ($month = 1; $month <= 12; $month++) {
//            $profit = Order::whereYear('created_at', date('Y'))
//                ->whereMonth('created_at', $month)
//                ->sum('commission_amount') ?? 0;

            $profits[] = number_format($profit ?? rand(100, 500), 2);
        }

        return [
            'categories' => $categories,
            'data' => $profits
        ];
    }

    public function profile() {
        return view('admin.admins.profile');
    }


    public function updateProfile(UpdateProfile $request) {
        auth('admin')->user()->update($request->validated());
        return back()->with('success' , __('admin.update_successfully'));
    }

    public function updatePassword(updatePassword $request) {
        if (!Hash::check($request->old_password , auth('admin')->user()->password)) {
            return back()->with('danger' , __('admin.not_old_password'));
        }
        auth('admin')->user()->update(['password' => $request->password]);
        return back()->with('success' , __('admin.update_successfully'));
    }

    public function chartData($model)
    {
        $users = $model::select('id', 'created_at')
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('Y-m');
            });
        $usermcount = [];
        $userArr = [];

        foreach ($users as $key => $value) {
            $usermcount[$key] = count($value);
        }
        for($i = 1; $i <= 12; $i++){
            $d = ($i < 10 )? date('Y').'-0'.$i : date('Y').'-'.$i;
            if(!empty($usermcount[$d])){
                $userArr[] = $usermcount[$d];
            }else{
                $userArr[] = 0;
            }
        }
        return $userArr ;

    }
}
