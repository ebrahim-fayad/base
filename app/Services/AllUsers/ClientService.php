<?php

namespace App\Services\AllUsers;


use App\Models\AllUsers\User;
use App\Models\IncentivePoint;
use App\Models\Meals\UserMeal;
use App\Models\Programs\LevelSubscription;
use App\Models\Programs\PhysicalActivityCompletion;
use App\Traits\FirebaseTrait;
use App\Services\Core\BaseService;
use App\Enums\NotificationTypeEnum;
use App\Models\PublicSections\Complaint;
use App\Models\Wallet\WalletTransaction;

class ClientService extends BaseService
{
    use FirebaseTrait;
    public function __construct()
    {
        $this->model = User::class;
    }

    public function details($user)
    {
        $html = '';

        if (request()->type == 'main_data') {
            $html = view('admin.clients.parts.main_data', ['row' => $user])->render();
        }
        if (request()->type == 'orders') {
            $orders = $user->orders ?? collect([]);
            $html = view('admin.clients.parts.orders', compact('orders'))->render();
        }
        if (request()->type == 'subscriptions') {
            $subscriptions = LevelSubscription::where('user_id', $user->id)
                ->with('level.days.exercises')
                ->orderByDesc('created_at')
                ->get();
            $completionsByLevel = PhysicalActivityCompletion::where('user_id', $user->id)
                ->with(['levelDay', 'dailyActivity'])
                ->get()
                ->groupBy('level_id');
            $html = view('admin.clients.parts.subscriptions', compact('user', 'subscriptions', 'completionsByLevel'))->render();
        }
        if (request()->type == 'daily_calories') {
            $datesWithMacros = UserMeal::where('user_id', $user->id)
                ->selectRaw('date, sum(total_calories) as total_calories, sum(total_protein) as total_protein, sum(total_carbohydrates) as total_carbs, sum(total_fats) as total_fats')
                ->groupBy('date')
                ->orderByDesc('date')
                ->get();
            $mealsByDate = UserMeal::where('user_id', $user->id)
                ->with(['mealType', 'components.mealItem'])
                ->get()
                ->groupBy(fn ($m) => $m->date->format('Y-m-d'));
            $html = view('admin.clients.parts.daily_calories', compact('user', 'datesWithMacros', 'mealsByDate'))->render();
        }
        if (request()->type == 'incentive_points') {
            $incentivePoints = IncentivePoint::where('user_id', $user->id)
                ->orderByDesc('created_at')
                ->get();
            $html = view('admin.clients.parts.incentive_points', compact('user', 'incentivePoints'))->render();
        }

        return ['html' => $html];
    }

    public function findOrNew($data = [])
    {
        $user = User::firstOrCreate($data, $data);
        return ['key' => 'success', 'msg' => 'success', 'data' => $user];
    }

    public function isRegistered($user): bool
    {
        return !isset($user->name, $user->email, $user->city_id, $user->country_id);
    }
}
