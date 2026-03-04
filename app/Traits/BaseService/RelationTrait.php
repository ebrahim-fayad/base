<?php

namespace App\Traits\BaseService;

use App\Enums\WalletTransactionEnum;
use App\Services\Core\WalletService;
use Illuminate\Database\Eloquent\Model;

trait RelationTrait
{
    /**
     * Attach a many-to-many relationship.
     */
    public function attachRelation(string $relation, Model $model, array $data, array $pivotData = []): array
    {
        try {
            $model->$relation()->attach($data, $pivotData);
            return ['key' => 'success', 'msg' => __('apis.success')];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Sync a many-to-many relationship.
     */
    public function syncRelation(string $relation, Model $model, array $data): array
    {
        try {
            $model->$relation()->sync($data);
            return ['key' => 'success', 'msg' => __('apis.success')];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Update or create a has-one relationship.
     */
    public function updateOrCreateRelation(string $relation, Model $model, array $data, array $conditions = []): array
    {
        try {
            $relationModel = $model->$relation()->updateOrCreate($conditions, $data);
            return ['key' => 'success', 'msg' => __('apis.success'), 'data' => $relationModel];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Create a record for a has-one or has-many relationship.
     *
     * @param string $relation The name of the relationship.
     * @param Model $model The parent model instance.
     * @param array $data The data to create the related record.
     * @return array Returns an array with a 'key' and 'msg' indicating the result.
     */
    public function createRelation(string $relation, Model $model, array $data): array
    {
        try {
            // Create the related record
            $relationModel = $model->$relation()->create($data);
            return ['key' => 'success', 'msg' => __('apis.success'), 'data' => $relationModel];
        } catch (\Exception $e) {
            // Handle any exceptions (e.g., database errors)
            return ['key' => 'error', 'msg' => __('apis.error_creating_relation'), 'error' => $e->getMessage()];
        }
    }

    /**
     * Create multiple records for a has-many relationship.
     *
     * @param string $relation The name of the relationship.
     * @param Model $model The parent model instance.
     * @param array $data An array of data arrays to create the related records.
     * @return array Returns an array with a 'key' and 'msg' indicating the result.
     */
    public function createManyRelation(string $relation, Model $model, array $data): array
    {
        try {
            // Create multiple related records
            $relationModels = $model->$relation()->createMany($data);
            return ['key' => 'success', 'msg' => __('apis.success'), 'data' => $relationModels];
        } catch (\Exception $e) {
            // Handle any exceptions (e.g., database errors)
            return ['key' => 'error', 'msg' => __('apis.error_creating_relation'), 'error' => $e->getMessage()];
        }
    }
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
                // $walletService->debt($user->wallet, $balance);
                $user->wallet->decrement('balance', $balance);
                $user->wallet->decrement('available_balance', $balance);
                $user->wallet->transactions()->create([
                    'type' => WalletTransactionEnum::DEBT->value,
                    'amount' => $balance
                ]);
            }

            return ['key' => 'success', 'msg' => __('admin.balance_updated'), 'balance' => $user->wallet?->balance];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}

