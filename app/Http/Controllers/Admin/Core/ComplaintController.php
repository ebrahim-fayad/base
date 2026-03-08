<?php

namespace App\Http\Controllers\Admin\Core;

use App\Enums\ComplaintStatusEnum;
use App\Enums\ComplaintTypesEnum;
use App\Models\PublicSections\Complaint;
use App\Services\PublicSections\ComplaintService;
use App\Http\Requests\Admin\PublicSections\Complaints\StoreReplayComplaintRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class ComplaintController extends AdminBasicController
{

    public function __construct()
    {
        // parent constructor parameters
        $this->model = Complaint::class;
        $this->directoryName = 'public-sections.complaints';
        $this->serviceName = new ComplaintService();
        $this->indexScopes = 'search';
        $this->with = ['complaintable'];
        $this->indexConditions = ['type' => ComplaintTypesEnum::Complaint->value];
    }

    public function replay($id,StoreReplayComplaintRequest  $request)
    {
        $this->serviceName->replay($id, $request->validated());
        return response()->json(['url' => route('admin.complaints.show', ['id' => $id])]);
    }

    public function update($id): JsonResponse|RedirectResponse
    {
        $complaint = $this->serviceName->find($id);
        $complaint->update(['status' => ComplaintStatusEnum::Pending->value]);
        return response()->json([
            'key' => 'success',
            'msg' => __('admin.status_updated_successfully'),
            'url' => route('admin.complaints.show', ['id' => $id])
        ]);
    }
}
