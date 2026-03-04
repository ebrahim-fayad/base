<?php

namespace App\Http\Controllers\Api\General;

use App\Enums\NotificationTypeEnum;
use App\Http\Resources\Api\General\Complaints\ComplaintLiteResource;
use App\Models\AllUsers\Admin;
use App\Notifications\GeneralNotification;
use App\Traits\ResponseTrait;
use App\Enums\ComplaintTypesEnum;
use Illuminate\Http\JsonResponse;
use App\Services\Core\BaseService;
use App\Http\Controllers\Controller;
use App\Models\PublicSections\Complaint;
use App\Http\Resources\Api\General\Complaints\ComplaintDetailsResource;
use App\Http\Requests\Api\General\Complaints\StoreComplaintRequest;
use App\Http\Requests\Api\General\Complaints\StoreContactUsRequest;
use App\Support\QueryOptions;
use Illuminate\Support\Facades\Notification;
use App\Traits\PaginationTrait;


class ComplaintController extends Controller
{
    use ResponseTrait, PaginationTrait;

    private $complaintService;
    public function __construct()
    {
        $this->complaintService = new BaseService(Complaint::class);
    }

    public function index(): JsonResponse
    {
        $options = (new QueryOptions())
            ->conditions([
                'complaintable_id' => auth()->id(),
                'complaintable_type' => get_class(auth()->user()),
                'type' => ComplaintTypesEnum::Complaint->value
            ])->paginateNum($this->paginateNum());
        $complaints = $this->complaintService->limit($options);
        return $this->jsonResponse(data: [
            'pagination' => $this->paginationModel($complaints),
            'complaints' => ComplaintLiteResource::collection($complaints)
        ]);
    }
    public function store(StoreComplaintRequest $request): JsonResponse
    {
        $complaint = $this->complaintService->create($request->validated());
        // $data = $this->complaintService->createManyRelation('images', $complaint, $request->validated()['images']);
        Notification::send(Admin::all(), new GeneralNotification($complaint, NotificationTypeEnum::NEW_COMPLAINT->value));
        return $this->jsonResponse(__('apis.success'), data: ComplaintLiteResource::make($complaint));
    }
    public function show($id): JsonResponse
    {
        try {
            $complaint = $this->complaintService->find($id, conditions: ['complaintable_id' => auth()->id(), 'complaintable_type' => get_class(auth()->user())]);
            return $this->jsonResponse(data: ComplaintDetailsResource::make($complaint));
        } catch (\Throwable $th) {
            throw new \Exception(__('apis.not_found'));
        }
    }

    public function storeContactUs(StoreContactUsRequest $request): JsonResponse
    {
        $complaint = $this->complaintService->create($request->validated());
        // $data = $this->complaintService->createRelation('images', $complaint, ['image' => $request->validated()['image']]);
        Notification::send(Admin::all(), new GeneralNotification($complaint, NotificationTypeEnum::NEW_CONTACT_US->value));
        return $this->jsonResponse(msg: __('apis.success'), data: ComplaintLiteResource::make($complaint));
    }
}
