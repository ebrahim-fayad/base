<?php

namespace App\Services\AllUsers;

use App\Enums\ApprovementStatusEnum;
use App\Enums\NotificationTypeEnum;
use App\Models\AllUsers\Provider;
use App\Models\ProviderUpdate;
use App\Models\PublicSections\Complaint;
use App\Models\Wallet\WalletTransaction;
use App\Notifications\GeneralNotification;
use App\Services\Core\BaseService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;

class ProviderService extends BaseService
{
    protected $provider;
    public function __construct()
    {
        $this->model = Provider::class;
    }

    public function details($provider)
    {
        if (request()->type == 'main_data') {
            $html = view('admin.providers.parts.main_data', ['row' => $provider])->render();
        }

        if (request()->type == 'complaints') {
            $complaints = Complaint::with('complaintable')->where(['complaintable_id' => $provider->id, 'complaintable_type' => get_class($provider)])->latest()->paginate(10);
            $html = view('admin.providers.parts.complaints', compact('complaints'))->render();
        }
        if (request()->type == 'orders') {
            $orders = $provider->orders()->latest()->paginate(10);
            $html = view('admin.providers.parts.orders', compact('orders'))->render();
        }
        if (request()->type == 'wallet') {
            $transactions = WalletTransaction::where('wallet_id', $provider->wallet?->id)->latest()->paginate(10);
            $html = view('admin.providers.parts.wallet_details', ['row' => $provider])->render();
            $html .= view('admin.providers.parts.transactions', compact('transactions'))->render();
        }


        // if (request()->type == 'updates') {
        //     $html = $this->getProviderUpdate($provider);
        // }




        return ['html' => $html];
    }

    public function create(array $data): Model
    {
        try {
            // Extract relationship data
            $categoriesIds = $data['categories_ids'] ?? [];
            $subCategoriesIds = $data['sub_categories_ids'] ?? [];
            $servicesIds = $data['services_ids'] ?? [];
            $bankAccountData = [
                'bank_name' => $data['bank_name'] ?? null,
                'bank_account_name' => $data['bank_account_name'] ?? null,
                'bank_account_number' => $data['bank_account_number'] ?? null,
                'iban' => $data['iban'] ?? null,
            ];

            // Remove relationship data from main data
            unset($data['categories_ids'], $data['sub_categories_ids'], $data['services_ids']);
            unset($data['bank_name'], $data['bank_account_name'], $data['bank_account_number'], $data['iban']);

            // Create provider
            $provider = parent::create($data);

            // Create bank account
            if (!empty(array_filter($bankAccountData))) {
                $this->createRelation('bankAccount', $provider, $bankAccountData);
            }

            // Sync categories
            if (!empty($categoriesIds)) {
                $provider->categories()->sync($categoriesIds);
            }

            // Sync sub categories
            if (!empty($subCategoriesIds)) {
                $provider->subCategories()->sync($subCategoriesIds);
            }

            // Sync services
            if (!empty($servicesIds)) {
                $provider->services()->sync($servicesIds);
            }

            return $provider;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function update(int|null $id, array $data, array $conditions = []): object|int
    {
        try {
            // Extract relationship data
            $categoriesIds = $data['categories_ids'] ?? null;
            $subCategoriesIds = $data['sub_categories_ids'] ?? null;
            $servicesIds = $data['services_ids'] ?? null;
            $bankAccountData = [
                'bank_name' => $data['bank_name'] ?? null,
                'bank_account_name' => $data['bank_account_name'] ?? null,
                'bank_account_number' => $data['bank_account_number'] ?? null,
                'iban' => $data['iban'] ?? null,
            ];

            // Remove relationship data from main data
            unset($data['categories_ids'], $data['sub_categories_ids'], $data['services_ids']);
            unset($data['bank_name'], $data['bank_account_name'], $data['bank_account_number'], $data['iban']);

            // Update provider
            $provider = $id ? $this->find($id, conditions: $conditions) : $this->model::where($conditions)->first();
            $provider->update($data);

            // Update or create bank account
            if (!empty(array_filter($bankAccountData))) {
                $this->updateOrCreateRelation('bankAccount', $provider, $bankAccountData);
            }

            // Sync categories if provided
            if ($categoriesIds !== null) {
                $provider->categories()->sync($categoriesIds);
            }

            // Sync sub categories if provided
            if ($subCategoriesIds !== null) {
                $provider->subCategories()->sync($subCategoriesIds);
            }

            // Sync services if provided
            if ($servicesIds !== null) {
                $provider->services()->sync($servicesIds);
            }

            return $provider;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function findOrNew($data = [])
    {
        $provider = Provider::firstOrCreate($data, $data);
        return ['key' => 'success', 'msg' => 'success', 'data' => $provider];
    }

    public function isRegistered($provider): bool
    {
        return !isset($provider->name, $provider->email, $provider->city_id);
    }

    public function toggleApprovement($data)
    {
        $isApproved = $data['is_approved'] == ApprovementStatusEnum::APPROVED->value;
        $provider = $this->find($data['id']);
        $msg = __('admin.accepted_successfully');
        $logMsg = 'قبول مقدم الخدمه';

        if (!$isApproved) {
            $msg = __('admin.rejected_successfully');
            $logMsg = 'رفض مقدم الخدمة';

            //TODO: send sms to provider
            // $provider->sendSms($provider->phone, $refuseReason);
            $provider->forceDelete();
        } else {
            $provider->update([
                'is_approved' => ApprovementStatusEnum::APPROVED->value,
            ]);
        }

        return [
            'key' => 'success',
            'msg' => $msg,
            'logMsg' => $logMsg,
        ];
    }
    public function getProviderUpdate($provider)
    {
        $update = $provider->updateRequest()->first();

        $html = view('admin.providers.parts.provider_updates', [
            'update' => $update,
            'provider' => $provider
        ])->render();

        return $html;
    }

    public function toggleUpdateRequest($request, $updateId)
    {
        $update = ProviderUpdate::findOrFail($updateId);
        $provider = $update->provider;
        $isApproved = $request->status == ApprovementStatusEnum::APPROVED->value;

        if ($isApproved) {
            // Get only non-null fields to update
            $dataToUpdate = [];
            $fieldsToUpdate = [
                'name',
                'email',
                'map_desc',
                'lat',
                'lng',
            ];

            foreach ($fieldsToUpdate as $field) {
                if (!is_null($update->$field)) {
                    $dataToUpdate[$field] = $update->$field;
                }
            }

            // Handle image separately to get raw value (not accessor)
            if (!is_null($update->getRawOriginal('image'))) {
                $dataToUpdate['image'] = $update->getRawOriginal('image');
            }

            // Update provider with new data
            $provider->update($dataToUpdate);

            // Sync categories if provided
            if (!is_null($update->categories_ids)) {
                $provider->categories()->sync($update->categories_ids);
            }

            // Sync sub categories if provided
            if (!is_null($update->sub_categories_ids)) {
                $provider->subCategories()->sync($update->sub_categories_ids);
            }

            $logMsg = 'قبول تحديث بيانات مقدم الخدمة';
            $msg = __('admin.accepted_successfully');
        } else {
            $logMsg = 'رفض تحديث بيانات مقدم الخدمة';
            $msg = __('admin.rejected_successfully');
        }
        $update->delete();
        $notificationType = $isApproved
            ? NotificationTypeEnum::PROVIDER_UPDATE_ACCEPTED->value
            : NotificationTypeEnum::PROVIDER_UPDATE_REJECTED->value;
        Notification::send($provider, new GeneralNotification($provider, $notificationType));

        return [
            'status' => 'success',
            'msg' => $msg,
            'logMsg' => $logMsg,
        ];
    }
}
