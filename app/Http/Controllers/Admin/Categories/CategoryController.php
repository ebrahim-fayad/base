<?php

namespace App\Http\Controllers\Admin\Categories;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Services\Core\BaseService;
use App\Http\Requests\Admin\Categories\StoreRequest;
use App\Http\Requests\Admin\Categories\UpdateRequest;
use App\Http\Controllers\Admin\Core\AdminBasicController;


class CategoryController extends AdminBasicController
{
    public function __construct()
    {
        $this->model = Category::class;
        $this->storeRequest = StoreRequest::class;
        $this->updateRequest = UpdateRequest::class;
        $this->directoryName = 'categories';
        $this->with = ['parent', 'children'];
        $this->indexScopes = 'search';
        $this->serviceName = new BaseService(Category::class);
        $this->indexConditions = ['parent_id' => null];
        $this->indexConditions = ['parent_id' => request()->route('parent_id')];
        $this->editCompactVariables = ['parentCategories' => Category::whereNull('parent_id')->orderBy('created_at', 'desc')->get()];
    }


    public function create(): View
    {
        return view('admin.' . $this->directoryName . '.create');
    }

    public function store(): JsonResponse|RedirectResponse
    {
        $this->storeRequest = app($this->storeRequest);
        $row = $this->serviceName->create($this->storeRequest->validated());
        $this->addToLog('  اضافه ' . $this->getClassNameTranslated());

        $url = $row->parent_id
            ? route('admin.categories.index', ['parent_id' => $row->parent_id])
            : route('admin.categories.index');

        return response()->json(['url' => $url]);
    }
}
