<?php

namespace App\Http\Controllers\Admin\AllUsers;

use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Admin\Core\AdminBasicController;
use App\Http\Requests\Admin\AllUsers\Client\StoreRequest;
use App\Http\Requests\Admin\AllUsers\Client\UpdateRequest;
use App\Http\Requests\Admin\Core\Notification\SendRequest;
use App\Http\Requests\Admin\Core\Wallet\UpdateBalanceRequest;
use App\Models\AllUsers\User;
use App\Services\AllUsers\ClientService;
use App\Services\Core\NotificationService;
use App\Services\CountryCities\CityService;
use App\Services\CountryCities\CountryService;
use App\Support\QueryOptions;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;


class ClientController extends AdminBasicController
{

    protected $countryService;
    protected $cityService;
    public function __construct()
    {
        $this->countryService = new CountryService();
        $this->cityService = new CityService();
        // parent constructor parameters
        $this->model = User::class;
        $this->storeRequest = StoreRequest::class;
        $this->updateRequest = UpdateRequest::class;
        $this->directoryName = 'clients';
        $this->serviceName = new ClientService();
        $this->indexScopes = 'search';
        $this->with = ['city', 'country'];
        $this->destroyRelationsToCheck = ['wallet', 'activeOrders'];
        $this->relationsConditions = [
            'wallet' => [['balance', '>', 0]],
        ];
        $this->destroyRelationMessages = [
            'wallet' => 'admin.cannot_delete_has_wallet_balance',
            'activeOrders' => 'admin.cannot_delete_has_active_orders',
        ];
        $options = (new QueryOptions())->withCount(['cities']);
        if (Route::currentRouteName() == 'admin.clients.create') {
            $this->createCompactVariables = [
                'countries' => $this->countryService->all($options),
            ];
        }
        if (Route::currentRouteName() == 'admin.clients.edit') {
            $this->editCompactVariables = [
                'countries' => $this->countryService->all($options),
            ];
        }
    }

    public function block(Request $request)
    {
        $data = $this->serviceName->toggleBlock($request->id);
        return response()->json(['message' => $data['msg']]);
    }


    public function notify(SendRequest $request, NotificationService $notificationService)
    {
        $notificationService->send($request);
        return response()->json();
    }

    public function updateBalance(UpdateBalanceRequest $request, $id)
    {
        $data = $this->serviceName->updateBalance(type: $request->type, id: $id, balance: $request->balance);
        return response()->json(['msg' => $data['msg'], 'balance' => $data['balance'] . ' ' . __('site.currency')]);
    }

    public function show($id): JsonResponse|View
    {
        $row = $this->serviceName->find($id);

        if (request()->ajax()) {
            $data = $this->serviceName->details(user: $row);
            return response()->json(['html' => $data['html']]);
        }

        return view('admin.clients.show', ['row' => $row]);
    }
}
