<?php

namespace App\Traits;

use App\Enums\NotificationTypeEnum;
use App\Notifications\GeneralNotification;
use App\Services\Core\WalletService;
use Illuminate\Support\Facades\Notification;

trait StatusTrait
{
    /**
     * Toggle the status of a record.
     */
    public function toggleStatus(int $id): array
    {
        try {
            $model = $this->find($id);
            $model->update(['status' => !$model->status]);
            $message = $model->status ? __('admin.active') : __('admin.dis_activate');
            return ['key' => 'success', 'msg' => $message, 'data' => $model];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Toggle the blocked status of a user and notify them.
     */
    public function toggleBlock(int $id): array
    {
        try {
            $user = $this->find($id);
            $user->update(['is_blocked' => !$user->is_blocked]);

            if ($user->is_blocked) {
                Notification::send($user, new GeneralNotification($user, NotificationTypeEnum::Admin_User_Block->value));
                return ['msg' => __('admin.blocked')];
            }

            return ['msg' => __('admin.unblocked')];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Update the balance of a user's wallet.
     */
    public function updateBalance(int $id, float $balance, int $type): array
    {
        try {
            $walletService = new WalletService();
            $user = $this->find($id);

            if ($balance <= 0) {
                return ['key' => 'fail', 'msg' => __('admin.invalid_balance'), 'balance' => $user->balance];
            }

            if ($type === 0) {
                $walletService->charge($user->wallet, $balance, $user);
            } else {
                if ($user->wallet?->balance < $balance) {
                    return ['key' => 'fail', 'msg' => __('admin.balance_not_enough'), 'balance' => $user->wallet?->balance];
                }
                $walletService->debt($user->wallet, $balance);
            }

            // إعادة تحميل العلاقة wallet للحصول على القيمة المحدثة من قاعدة البيانات
            // إزالة العلاقة من الذاكرة وإعادة تحميلها
            $user->unsetRelation('wallet');
            $user->load('wallet');

            // التأكد من الحصول على القيمة المحدثة
            $updatedBalance = $user->wallet?->balance ?? 0;

            return ['key' => 'success', 'msg' => __('admin.balance_updated'), 'balance' => $updatedBalance];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}

