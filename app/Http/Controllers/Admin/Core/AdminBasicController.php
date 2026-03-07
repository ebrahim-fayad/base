<?php

namespace App\Http\Controllers\Admin\Core;

use Illuminate\View\View;
use App\Traits\ReportTrait;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Support\QueryOptions;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;


class
AdminBasicController extends Controller
{
    use ReportTrait;

    public function __construct(
        protected        $model,
        protected        $storeRequest,
        protected        $updateRequest,
        protected string $directoryName,
        protected object $serviceName,
        protected string $indexScopes = '',
        protected array  $with = [],
        protected array  $indexConditions = [],
        protected array  $indexCompactVariables = [],
        protected array  $createCompactVariables = [],
        protected array  $editCompactVariables = [],
        protected array  $showCompactVariables = [],
        protected array  $destroyOneConditions = [],
        protected array  $destroyRelationsToCheck = [],
        protected array  $relationsConditions = [],
        protected array  $destroyRelationMessages = []
    ) {}

    protected function modelName(): string
    {
        return (string) Str::of($this->model)->afterLast('\\')->lower();
        //        return Str::replace('app\models\\', '', strtolower($this->model));
    }

    protected function getClassNameTranslated(): string
    {
        return __('admin.' . $this->modelName());
    }

    protected function pluralModelName(): string
    {
        return Str::plural($this->modelName());
    }

    public function index(): View|JsonResponse
    {

        if (request()->ajax()) {
            $limitOptions = (new QueryOptions())
                ->paginateNum($this->paginateNum())
                ->scopes($this->indexScopes ?? 'search')
                ->conditions($this->indexConditions ?? [])
                ->with($this->with ?? [])
                ->latest(false);
            $rows = $this->serviceName->limit($limitOptions);
            $html = view('admin.' . $this->directoryName . '.table', compact(var_name: 'rows'))->render();

            $countOptions = (new QueryOptions())->conditions($this->indexConditions ?? []);
            return response()->json(['html' => $html, 'modelCount' => $this->serviceName->count($countOptions)]);
        }

        $countOptions = (new QueryOptions())->conditions($this->indexConditions ?? []);
        return view(
            'admin.' . $this->directoryName . '.index',
            isset($this->indexCompactVariables) ?
                array_merge($this->indexCompactVariables, ['modelCount' => $this->serviceName->count($countOptions)]) :
                ['modelCount' => $this->serviceName->count($countOptions)]
        );
    }

    public function create(): View
    {
        return view('admin.' . $this->directoryName . '.create', $this->createCompactVariables ?? []);
    }

    public function store(): JsonResponse|RedirectResponse
    {
        $this->storeRequest = app($this->storeRequest);

        $this->serviceName->create($this->storeRequest->validated());
        $this->addToLog('  اضافه ' . $this->getClassNameTranslated());

        return response()->json(['url' => route($this->currentRouteName() . '.index')]);
    }

    public function update($id): JsonResponse|RedirectResponse
    {

        $this->updateRequest = app($this->updateRequest);
        $this->serviceName->update(data: $this->updateRequest->validated(), id: $id);
        $this->addToLog('  تعديل ' . $this->getClassNameTranslated());

        return response()->json(['url' => route($this->currentRouteName() . '.index')]);
    }

    public function edit($id): View
    {
        $row = $this->serviceName->find($id);
        return view('admin.' . $this->directoryName . '.edit', array_merge(['row' => $row], $this->editCompactVariables ?? []));
    }

    public function show($id): View|JsonResponse
    {
        $row = $this->serviceName->find(id: $id, with: $this->with ?? []);
        return view('admin.' . $this->directoryName . '.show', array_merge(['row' => $row], $this->showCompactVariables ?? []));
    }

    public function destroy($id): JsonResponse
    {
        $result = $this->serviceName->delete(
            id: $id,
            relationsToCheck: $this->destroyRelationsToCheck ?? [],
            conditions: $this->destroyOneConditions ?? [],
            relationConditions: $this->relationsConditions ?? [],
            relationMessages: $this->destroyRelationMessages ?? []
        );
        $this->addToLog('  حذف ' . $this->getClassNameTranslated());
        return response()->json(['key' => $result['key'], 'msg' => $result['msg']]);
    }

    public function destroyAll(Request $request): JsonResponse
    {
        $result = $this->serviceName->deleteMultiple(request: $request, relationsToCheck: $this->destroyRelationsToCheck
            ?? [], relationConditions: $this->relationsConditions ?? [], relationMessages: $this->destroyRelationMessages ?? []);
        $this->addToLog('  حذف العديد من  ' . $this->getClassNameTranslated());
        return response()->json(['key' => $result['key'], 'msg' => $result['msg']]);
    }

    protected function currentRouteName(): string
    {
        $currentRouteName = request()->route()->getName();
        return substr($currentRouteName, 0, strrpos($currentRouteName, '.'));
    }

    private function getRedirectUrl(?string $targetRoute): ?string
    {
        $targetIsValid = Route::has($targetRoute);

        try {
            if ($targetIsValid) {
                return route($targetRoute);
            } else {
                $request = Request::create(url()->previous());
                $route = app('router')->getRoutes()->match($request);

                // اسم الراوت (ممكن يكون null)، وبرامز الراوت (id, course, ...):
                $name = $route->getName();
                $params = $route->parameters();

                // لو مفيش اسم، رجّع الـ prev مباشرة
                return $name ? route($name, $params) : route($targetRoute);
            }
        } catch (\Throwable) {
            return route($targetRoute);
        }
    }
}
