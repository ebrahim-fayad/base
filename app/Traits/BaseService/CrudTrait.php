<?php

namespace App\Traits\BaseService;

use App\Enums\NotificationTypeEnum;
use App\Models\Core\AuthBaseModel;
use App\Notifications\GeneralNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;

trait CrudTrait
{
    /**
     * Create a new record.
     */
    public function create(array $data): Model
    {
        try {
            return $this->model::create($data);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Update a record by ID.
     */
    public function update(int|null $id, array $data, array $conditions = []): object|int
    {
        try {
            return $id ?
                $this->find($id, conditions: $conditions)->update($data) :
                $this->model::where($conditions)->update($data);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Delete a record by ID after checking for related data.
     *
     * @param int $id The ID of the record to delete.
     * @param array $relationsToCheck An array of relations to check for existence.
     * @return array Returns an array with a 'key' and 'msg' indicating the result.
     */
    public function delete(int $id, array $relationsToCheck = [], array $conditions = [], array $relationConditions = [], array $relationMessages = []): array
    {

        try {
            // Find the record or fail
            $record = $this->find(id: $id, conditions: $conditions);

            // Check if any of the specified relations exist
            foreach ($relationsToCheck as $relation) {
                $conditionsOfRelation = $relationConditions[$relation] ?? [];
                if ($record->$relation()->where($conditionsOfRelation)->exists()) {
                    // Use custom message for this relation if provided, otherwise use default message
                    $messageKey = $relationMessages[$relation] ?? 'admin.record_has_related_data_and_cannot_be_deleted';
                    return ['key' => 'error', 'msg' => __($messageKey)];
                }
            }

            // إرسال إشعار للمستخدم قبل الحذف (Admin, Provider, User)
            if ($record instanceof AuthBaseModel) {
                Notification::send(
                    $record,
                    new GeneralNotification(
                        $record,
                        NotificationTypeEnum::Admin_User_Delete->value
                    )
                );
            }

            // If no related data exists, delete the record
            $record->delete();

            return ['key' => 'success', 'msg' => __('admin.deleted_successfully')];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function deleteMultiple($request, array $relationsToCheck = [], array $conditions = [], array $relationConditions = [], array $relationMessages = []): array
    {
        try {
            $requestIds = json_decode($request['data'], true);

            // Initialize a flag to track if any record has related data
            $hasRelatedData = false;
            $firstRelationFound = null;

            // Loop through each ID
            foreach (array_column($requestIds, 'id') as $id) {
                // Find the record or fail
                $record = $this->model::where($conditions)->findOrFail($id);

                // Check if any of the specified relations exist
                foreach ($relationsToCheck as $relation) {
                    $conditionsOfRelation = $relationConditions[$relation] ?? [];
                    if ($record->$relation()->where($conditionsOfRelation)->exists()) {
                        $hasRelatedData = true;
                        $firstRelationFound = $firstRelationFound ?? $relation;
                        break 2; // Exit both loops if related data is found
                    }
                }
                if ($record instanceof AuthBaseModel) {
                    Notification::send(
                        $record,
                        new GeneralNotification(
                            $record,
                            NotificationTypeEnum::Admin_User_Delete->value
                        )
                    );
                }
                // If no related data exists, delete the record
                $record->delete();
            }

            // Use custom message for the first relation found if provided
            if ($hasRelatedData && $firstRelationFound) {
                $messageKey = $relationMessages[$firstRelationFound] ?? 'admin.some_records_have_related_data_and_cannot_be_deleted';
                return [
                    'key' => 'warning',
                    'msg' => __($messageKey)
                ];
            }

            return [
                'key' => $hasRelatedData ? 'warning' : 'success',
                'msg' => $hasRelatedData ? __('admin.some_records_have_related_data_and_cannot_be_deleted') :
                    __('admin.All_selected_records_have_been_deleted')
            ];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function deleteWhere(array $conditions): int
    {
        return $this->model::where($conditions)->delete();
    }
}

