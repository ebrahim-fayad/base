<?php

namespace App\Http\Controllers\Admin\AllUsers;

use Illuminate\View\View;
use App\Traits\ReportTrait;
use Illuminate\Http\Request;
use App\Support\QueryOptions;
use App\Models\AllUsers\Provider;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use App\Services\AllUsers\ProviderService;
use App\Services\Core\NotificationService;
use App\Services\CountryCities\CountryService;
use App\Http\Controllers\Admin\Core\AdminBasicController;
use App\Http\Requests\Admin\Core\Notification\SendRequest;
use App\Http\Requests\Admin\AllUsers\Provider\StoreRequest;
use App\Http\Requests\Admin\AllUsers\Provider\UpdateRequest;
use App\Http\Requests\Admin\Core\Wallet\UpdateBalanceRequest;
use App\Http\Requests\Admin\AllUsers\Provider\ToggleApprovementRequest;



class ProviderController extends AdminBasicController
{
    protected $countryService;
    public function __construct()
    {
        // parent constructor parameters
        $this->model = Provider::class;
        $this->with = ['updateRequest','wallet','orders'];
        $this->storeRequest = StoreRequest::class;
        $this->updateRequest = UpdateRequest::class;
        $this->directoryName = 'providers';
        $this->indexScopes = 'search';
        $this->destroyRelationsToCheck = ['wallet','orders'];
        $this->relationsConditions = [
            'wallet' => [['balance', '>', 0]],
        ];
        $this->destroyRelationMessages = ['updateRequest' => 'admin.record_has_related_data_and_cannot_be_deleted','wallet' => 'admin.cannot_delete_has_wallet_balance','orders' => 'admin.cannot_delete_has_active_orders'];
        $this->serviceName = new ProviderService();
        $this->countryService = new CountryService();


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

    public function store(): JsonResponse|RedirectResponse
    {
        $this->storeRequest = app($this->storeRequest);
        $provider = $this->serviceName->create($this->storeRequest->validated());



        $this->addToLog('  اضافه ' . $this->getClassNameTranslated());

        return response()->json(['url' => route('admin.providers.index')]);
    }

    public function edit($id): View
    {
        $row = $this->serviceName->find($id, with: ['categories', 'subCategories', 'services', 'bankAccount']);
        return view('admin.' . $this->directoryName . '.edit', array_merge(['row' => $row], $this->editCompactVariables ?? []));
    }

    public function update($id): JsonResponse|RedirectResponse
    {

        $this->updateRequest = app($this->updateRequest);
        $provider = $this->serviceName->update(id: $id, data: $this->updateRequest->validated());



        $this->addToLog('  تعديل ' . $this->getClassNameTranslated());

        return response()->json(['url' => route($this->currentRouteName() . '.index')]);
    }
    public function block(Request $request)
    {
        $data = $this->serviceName->toggleBlock($request->id);
        return response()->json(['key' => 'success', 'message' => $data['msg']]);
    }


    public function notify(SendRequest $request, NotificationService $notificationService)
    {
        $notificationService->send($request);
        return response()->json();
    }

    public function updateBalance(UpdateBalanceRequest $request, $id)
    {
        $data = $this->serviceName->updateBalance(type: $request->type, id: $id, balance: $request->balance);
        return response()->json(['msg' => $data['msg'], 'balance' => $data['balance']]);
    }

    public function show($id): JsonResponse|View
    {

        $row = $this->serviceName->find($id,with: ['orders','complaints']);

        if (request()->ajax()) {
            $data = $this->serviceName->details($row);
            return response()->json(['html' => $data['html']]);
        }

        return view('admin.providers.show', ['row' => $row,]);
    }

    public function toggleApprovement(ToggleApprovementRequest $request)
    {
        try {

            $data = $this->serviceName->toggleApprovement($request->validated());

            ReportTrait::addToLog($data['logMsg']);

            return response()->json([
                'status' => 'success',
                'message' => $data['msg']
            ]);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'status' => 'error',
                'message' => __('admin.an_error_occurred'),
            ]);
        }
    }

    /**
     * Get provider update for display (one-to-one)
     */
    public function getProviderUpdates($id): JsonResponse
    {
        $provider = $this->serviceName->find($id);

        $html = $this->serviceName->getProviderUpdate($provider);

        return response()->json(['html' => $html]);
    }

    /**
     * Accept provider update - applies changes and deletes the update request
     */
    public function toggleProviderUpdate(Request $request, $updateId): JsonResponse
    {
        try {
            $data = $this->serviceName->toggleUpdateRequest($request, $updateId);

            ReportTrait::addToLog($data['logMsg']);

            return response()->json([
                'status' => $data['status'],
                'message' => $data['msg'],
            ]);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'status' => 'error',
                'message' => __('admin.an_error_occurred'),
            ], 500);
        }
    }


}
