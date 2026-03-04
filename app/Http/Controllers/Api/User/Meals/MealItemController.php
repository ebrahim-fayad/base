<?php

namespace App\Http\Controllers\Api\User\Meals;

use App\Facades\BaseService as FacadesBaseService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Basics\BasicResourceWithImage;
use App\Models\Meals\MealItem;
use App\Support\QueryOptions;
use App\Traits\PaginationTrait;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class MealItemController extends Controller
{
    use ResponseTrait, PaginationTrait;

    /**
     * إرجاع أصناف الوجبات النشطة (كل القيم لكل 100 جرام)
     */
    public function index(): JsonResponse
    {
        $mealItemService = FacadesBaseService::setModel(MealItem::class);
        $options = (new QueryOptions())
            ->scopes('active')
            ->latest(true);

        $mealItems = $mealItemService->limit($options);
        return $this->jsonResponse(data: [
            'meal_items' => BasicResourceWithImage::collection($mealItems),
            'pagination' => $this->paginationModel($mealItems),
        ]);
    }
}
