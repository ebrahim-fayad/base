<?php

namespace App\Http\Controllers\Admin\MealTypes;

use App\Http\Controllers\Admin\Core\AdminBasicController;
use App\Http\Requests\Admin\MealTypes\StoreRequest;
use App\Http\Requests\Admin\MealTypes\UpdateRequest;
use App\Models\Meals\MealType;
use App\Services\Core\BaseService;

class MealTypeController extends AdminBasicController
{
    public function __construct()
    {
        $this->model = MealType::class;
        $this->storeRequest = StoreRequest::class;
        $this->updateRequest = UpdateRequest::class;
        $this->directoryName = 'meal_types';
        $this->serviceName = new BaseService(MealType::class);
        $this->indexScopes = 'search';
        $this->indexConditions = [];
        $this->destroyRelationsToCheck = [];
    }
}
