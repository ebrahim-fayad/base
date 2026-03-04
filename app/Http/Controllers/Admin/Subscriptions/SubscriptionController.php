<?php

namespace App\Http\Controllers\Admin\Subscriptions;

use App\Http\Controllers\Controller;
use App\Models\Programs\LevelSubscription;
use Illuminate\Contracts\View\View;

class SubscriptionController extends Controller
{
    public function index(): View
    {
        $subscriptions = LevelSubscription::with(['user', 'level'])
            ->latest()
            ->paginate(20);

        return view('admin.subscriptions.index', compact('subscriptions'));
    }
}
