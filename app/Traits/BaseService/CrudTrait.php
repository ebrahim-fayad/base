<?php

namespace App\Traits\BaseService;

use App\Enums\NotificationTypeEnum;
use App\Models\Core\AuthBaseModel;
use App\Notifications\GeneralNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;

trait CrudTrait
{
    public function create(array $data): Model
    {
        try {
            return $this->model::create($data);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function update(?int $id, array $data, array $conditions = []): object|int
    {
        try {
            if ($id) {
                return $this->find($id, conditions: $conditions)->update($data);
            }

            return $this->model::where($conditions)->update($data);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function delete(
        int $id,
        array $relationsToCheck = [],
        array $conditions = [],
        array $relationConditions = [],
        array $relationMessages = []
    ): array {
        try {
            $record = $this->find(id: $id, conditions: $conditions);

            $relatedCheck = $this->getRelationBlockingDelete($record, $relationsToCheck, $relationConditions);
            if ($relatedCheck) {
                $messageKey = $relationMessages[$relatedCheck] ?? 'admin.record_has_related_data_and_cannot_be_deleted';
                return ['key' => 'error', 'msg' => __($messageKey)];
            }

            if ($record instanceof AuthBaseModel) {
                $this->sendDeleteNotification($record);
                $this->cleanupAuthRelated($record);
            }

            $record->delete();

            return ['key' => 'success', 'msg' => __('admin.deleted_successfully')];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function deleteMultiple(
        $request,
        array $relationsToCheck = [],
        array $conditions = [],
        array $relationConditions = [],
        array $relationMessages = []
    ): array {
        try {
            $requestIds = json_decode($request['data'], true);
            $ids = array_column($requestIds, 'id');
            $hasRelatedData = false;
            $firstRelationFound = null;

            foreach ($ids as $id) {
                $record = $this->model::where($conditions)->findOrFail($id);

                $blockedRelation = $this->getRelationBlockingDelete($record, $relationsToCheck, $relationConditions);
                if ($blockedRelation) {
                    $hasRelatedData = true;
                    $firstRelationFound = $firstRelationFound ?? $blockedRelation;
                    break;
                }

                if ($record instanceof AuthBaseModel) {
                    $this->sendDeleteNotification($record);
                    $this->cleanupAuthRelated($record);
                }

                $record->delete();
            }

            if ($hasRelatedData && $firstRelationFound) {
                $messageKey = $relationMessages[$firstRelationFound] ?? 'admin.some_records_have_related_data_and_cannot_be_deleted';
                return [
                    'key' => 'warning',
                    'msg' => __($messageKey)
                ];
            }

            return [
                'key' => $hasRelatedData ? 'warning' : 'success',
                'msg' => $hasRelatedData
                    ? __('admin.some_records_have_related_data_and_cannot_be_deleted')
                    : __('admin.All_selected_records_have_been_deleted')
            ];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function deleteWhere(array $conditions): int
    {
        return $this->model::where($conditions)->delete();
    }

    private function getRelationBlockingDelete(Model $record, array $relationsToCheck, array $relationConditions): ?string
    {
        foreach ($relationsToCheck as $relation) {
            $conditionsOfRelation = $relationConditions[$relation] ?? [];
            if ($record->$relation()->where($conditionsOfRelation)->exists()) {
                return $relation;
            }
        }
        return null;
    }

    private function sendDeleteNotification(AuthBaseModel $record): void
    {
        Notification::send(
            $record,
            new GeneralNotification(
                $record,
                NotificationTypeEnum::Admin_User_Delete->value
            )
        );
    }

    private function cleanupAuthRelated(AuthBaseModel $record): void
    {
        $record->tokens()->delete();
        $record->devices()->delete();

        \DB::table('sessions')->where('user_id', $record->id)->delete();
    }
}