<?php

namespace App\Http\Controllers\Admin\MealItems;

use App\Http\Controllers\Admin\Core\AdminBasicController;
use App\Http\Requests\Admin\MealItems\StoreRequest;
use App\Http\Requests\Admin\MealItems\UpdateRequest;
use App\Models\Meals\MealItem;
use App\Services\Core\BaseService;

class MealItemController extends AdminBasicController
{
    public function __construct()
    {
        $this->model = MealItem::class;
        $this->storeRequest = StoreRequest::class;
        $this->updateRequest = UpdateRequest::class;
        $this->directoryName = 'meal_items';
        $this->serviceName = new BaseService(MealItem::class);
        $this->indexScopes = 'search';
        $this->indexConditions = [];
        $this->destroyRelationsToCheck = [];
    }
}
