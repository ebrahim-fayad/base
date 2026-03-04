<?php

namespace App\Http\Controllers\Api\User\Meals;

use App\Facades\BaseService as FacadesBaseService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Basics\BasicResource;
use App\Models\Meals\MealType;
use App\Support\QueryOptions;
use App\Traits\PaginationTrait;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class MealTypeController extends Controller
{
    use ResponseTrait,PaginationTrait;


    /**
     * قائمة أنواع الوجبات النشطة فقط (للعميل)
     */
    public function index(): JsonResponse
    {
        $mealTypeService = FacadesBaseService::setModel(MealType::class);
        $options = (new QueryOptions())
            ->scopes('active')
            ->latest(true);

        $mealTypes = $mealTypeService->limit($options);

        return $this->jsonResponse(data: [
            'meals' => BasicResource::collection($mealTypes),
            'pagination' => $this->paginationModel($mealTypes)
        ]);
    }
}
