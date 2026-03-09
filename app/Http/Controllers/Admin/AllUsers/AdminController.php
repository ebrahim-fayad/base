<?php

namespace App\Http\Controllers\Admin\AllUsers;

use App\Services\Core\BaseService;
use App\Traits\ReportTrait;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Models\AllUsers\Admin;
use Illuminate\Support\Facades\Route;
use App\Services\AllUsers\AdminService;
use App\Services\Core\NotificationService;
use App\Services\PublicSettings\RoleService;
use App\Services\CountryCities\CountryService;
use App\Http\Requests\Admin\AllUsers\Admin\StoreRequest;
use App\Http\Controllers\Admin\Core\AdminBasicController;
use App\Http\Requests\Admin\AllUsers\Admin\UpdateRequest;
use App\Support\QueryOptions;


class AdminController extends AdminBasicController
{

    use ResponseTrait, ReportTrait;

    protected $countryService, $adminService, $roleService;

    public function __construct()
    {
        $this->countryService = new CountryService();
        $this->roleService = new RoleService();

        // parent constructor parameters
        $this->model = Admin::class;
        $this->storeRequest = StoreRequest::class;
        $this->updateRequest = UpdateRequest::class;
        $this->directoryName = 'admins';
        $this->serviceName = new BaseService(Admin::class);
        $this->indexScopes = 'search';
        $this->indexConditions = ['type' => 'admin'];
        if (Route::currentRouteName() == 'admin.admins.create') {
            $options = new QueryOptions();
            $this->createCompactVariables = [
                'roles'     => $this->roleService->all($options),
                'countries' => $this->countryService->all($options),
            ];
        }
        if (Route::currentRouteName() == 'admin.admins.edit') {
            $options = new QueryOptions();
            $this->editCompactVariables = [
                'roles'     => $this->roleService->all($options),
                'countries' => $this->countryService->all($options),
            ];
        }
        $this->destroyOneConditions = [['id', '!=', 1]];
    }

    public function block(Request $request)
    {
        $response = $this->serviceName->toggleBlock(id: $request->id);
        return response()->json(['message' => $response['msg']]);
    }

    public function notifications(NotificationService $notificationService)
    {
        $notificationService->markAsReadNotifications(auth('admin')->user());
        return view('admin.admins.notifications');
    }

    public function deleteNotifications(Request $request, NotificationService $notificationService)
    {
        $data = $notificationService->deleteSelected(user: auth('admin')->user(), request: $request);
        return $this->successMsg($data['msg']);
    }

    public function restore(Request $request, $id)
    {
        try {
            // البحث عن الـ Admin المحذوف
            $admin = Admin::withTrashed()->findOrFail($id);
            
            if (!$admin->trashed()) {
                return response()->json([
                    'key' => 'error',
                    'msg' => __('admin.admin_not_deleted')
                ], 400);
            }
            
            // حذف جميع الـ tokens القديمة
            $admin->tokens()->delete();
            
            // حذف جميع الأجهزة القديمة
            $admin->devices()->delete();
            
            // استرجاع الحساب
            $admin->restore();
            
            return response()->json([
                'key' => 'success',
                'msg' => __('admin.restored_successfully')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'key' => 'error',
                'msg' => $e->getMessage()
            ], 500);
        }
    }
}
