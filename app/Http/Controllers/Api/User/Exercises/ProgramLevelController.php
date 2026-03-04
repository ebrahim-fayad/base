<?php

namespace App\Http\Controllers\Api\User\Exercises;

use App\Facades\BaseService as FacadesBaseService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\SubscribeRequest;
use App\Http\Resources\Api\User\ProgramLevelDetailResource;
use App\Http\Resources\Api\User\ProgramLevelResource;
use App\Models\Programs\Level;
use App\Models\Programs\LevelSubscription;
use App\Services\Core\BaseService;
use App\Support\QueryOptions;
use App\Traits\PaginationTrait;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class ProgramLevelController extends Controller
{
    use ResponseTrait, PaginationTrait;

    protected $levelsService;
    public function __construct()
    {
        $this->levelsService = new BaseService(Level::class);
    }

    /**
     * إرجاع المستويات الفعالة التي تحتوي على 30 يوم وكل يوم فيه 4 تمارين
     */
    public function index(): JsonResponse
    {
        $options = new QueryOptions();
        $options->scopes('active')
            ->withCount(['days'])
            ->with(['days' => fn($q) => $q->withCount('exercises')])
            ->custom(function ($q) {
                $q->orderBy('order')
                    ->having('days_count', '=', 30)
                    ->whereDoesntHave('days', fn($day) => $day->has('exercises', '!=', 4));
            });

        $levels = $this->levelsService->limit($options);
        return $this->jsonResponse(data: [
            'levels' => ProgramLevelResource::collection($levels),
            'pagination' => $this->paginationModel($levels),
        ]);
    }

    public function show($id): JsonResponse
    {
        $level = $this->levelsService->find($id, with: ['days.exercises']);
        return $this->jsonResponse(data: new ProgramLevelDetailResource($level));
    }

    public function subscribe(SubscribeRequest $request): JsonResponse
    {
        FacadesBaseService::setModel(LevelSubscription::class)
            ->create($request->validated());

        $this->levelsService->find((int) $request->validated()['level_id'], with: ['days.exercises']);

        return $this->jsonResponse(msg: __('apis.subscribed_successfully'));
    }
}
