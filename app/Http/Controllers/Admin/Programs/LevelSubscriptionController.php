<?php

namespace App\Http\Controllers\Admin\Programs;

use App\Http\Controllers\Controller;
use App\Models\Programs\Level;
use App\Models\Programs\LevelSubscription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LevelSubscriptionController extends Controller
{
    public function subscribers(int $levelId): View
    {
        $level = Level::findOrFail($levelId);
        $subscriptions = LevelSubscription::with('user')
            ->where('level_id', $levelId)
            ->paginate(20);
        return view('admin.levels.subscribers', compact('level', 'subscriptions'));
    }

    public function toggleClientStatus(Request $request): JsonResponse
    {
        $sub = LevelSubscription::findOrFail($request->id);
        $sub->update(['active' => !$sub->active]);
        return response()->json([
            'message' => $sub->active ? __('admin.activate') : __('admin.dis_activate'),
            'active' => $sub->active,
        ]);
    }
}
