<?php

namespace App\Http\Controllers\Admin\Programs;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Support\QueryOptions;
use App\Models\Programs\Level;
use Illuminate\Http\JsonResponse;
use App\Services\Core\BaseService;
use App\Http\Requests\Admin\Programs\StoreLevelRequest;
use App\Http\Requests\Admin\Programs\UpdateLevelRequest;
use App\Http\Controllers\Admin\Core\AdminBasicController;

class LevelController extends AdminBasicController
{
    public function __construct()
    {
        $this->model = Level::class;
        $this->storeRequest = StoreLevelRequest::class;
        $this->updateRequest = UpdateLevelRequest::class;
        $this->directoryName = 'levels';
        $this->serviceName = new BaseService(Level::class);
        $this->indexScopes = 'search->order';
        $this->with = ['days.exercises', 'subscriptions.user'];
        // منع حذف المستوى إذا كان فيه اشتراكات فعالة
        $this->destroyRelationsToCheck = ['subscriptions'];
        $this->relationsConditions = ['subscriptions' => [
            ['completed_days', '<', Level::DURATION_DAYS],
            ['incomplete_days', '>', 0]
        ]];
    }

    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            $limitOptions = (new QueryOptions())
                ->paginateNum(30)
                ->scopes($this->indexScopes ?? 'search')
                ->conditions($this->indexConditions ?? [])
                ->with($this->with ?? [])
                ->latest(false);
            $rows = $this->serviceName->limit($limitOptions);
            $html = view('admin.' . $this->directoryName . '.table', compact('rows'))->render();

            $countOptions = (new QueryOptions())->conditions($this->indexConditions ?? []);
            return response()->json(['html' => $html, 'modelCount' => $this->serviceName->count($countOptions)]);
        }

        $countOptions = (new QueryOptions())->conditions($this->indexConditions ?? []);
        return view(
            'admin.' . $this->directoryName . '.index',
            array_merge($this->indexCompactVariables ?? [], ['modelCount' => $this->serviceName->count($countOptions)])
        );
    }

    public function edit($id): View
    {
        $row = $this->serviceName->find($id, with: ['days.exercises']);
        return view('admin.' . $this->directoryName . '.edit', ['level' => $row]);
    }

    public function show($id): View|JsonResponse
    {
        $level = $this->serviceName->find(id: $id, with: $this->with ?? []);
        $level->ensureHasThirtyDays()->load(['days.exercises', 'subscriptions.user']);
        return view('admin.' . $this->directoryName . '.show', ['level' => $level]);
    }

    public function toggleStatus(Request $request): JsonResponse
    {
        $level = Level::findOrFail($request->id);
        $level->update(['active' => !$level->active]);
        $msg = $level->active ? __('admin.activate') : __('admin.dis_activate');
        $this->addToLog(" تغيير حالة مستوى: {$msg}");
        return response()->json(['message' => $msg, 'active' => $level->active]);
    }
}
