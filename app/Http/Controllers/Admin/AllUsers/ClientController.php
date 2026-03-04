<?php

namespace App\Http\Controllers\Admin\AllUsers;

use App\Http\Requests\Admin\Core\Wallet\UpdateBalanceRequest;
use Illuminate\Http\Request;
use App\Models\AllUsers\User;
use Illuminate\Http\JsonResponse;
use App\Services\AllUsers\ClientService;
use App\Services\Core\NotificationService;
use App\Services\CountryCities\CountryService;
use App\Http\Controllers\Admin\Core\AdminBasicController;
use App\Http\Requests\Admin\AllUsers\Client\StoreRequest;
use App\Http\Requests\Admin\AllUsers\Client\UpdateRequest;
use App\Http\Requests\Admin\AllUsers\Client\UpdateNutritionalRequest;
use App\Http\Requests\Admin\Core\Notification\SendRequest;
use Illuminate\View\View;
use App\Enums\NotificationTypeEnum;
use App\Notifications\GeneralNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;
use App\Support\QueryOptions;
use Illuminate\Support\Facades\Route;



class ClientController extends AdminBasicController
{

    protected $countryService;
    protected $cityService;
    public function __construct()
    {
        $this->countryService = new CountryService();
        // parent constructor parameters
        $this->model = User::class;
        $this->storeRequest = StoreRequest::class;
        $this->updateRequest = UpdateRequest::class;
        $this->directoryName = 'clients';
        $this->serviceName = new ClientService();
        $this->indexScopes = 'search';
        $this->with = [];
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


    public function show($id): JsonResponse|View
    {
        $row = $this->serviceName->find($id);

        if (request()->ajax()) {
            $data = $this->serviceName->details(user: $row);
            return response()->json(['html' => $data['html']]);
        }

        return view('admin.clients.show', ['row' => $row]);
    }


    public function updateNutritional(UpdateNutritionalRequest $request, $id): JsonResponse
    {
        $row = $this->serviceName->find($id);
        $row->update($request->validated());
        return response()->json(['msg' => __('admin.update_successfully')]);
    }

    /**
     * Remove the specified user.
     */
    public function destroy($id): JsonResponse
    {
        // Get user before deletion to send notification
        $user = $this->serviceName->find($id);

        // Send notification to user before deletion
        if ($user) {
            try {
                Notification::send($user, new GeneralNotification($user, NotificationTypeEnum::DELETE_ACCOUNT->value));
            } catch (\Exception $e) {
                // Log error but don't fail the deletion
                Log::error('Failed to send delete notification: ' . $e->getMessage());
            }
        }

        // Call parent destroy method
        return parent::destroy($id);
    }
}
