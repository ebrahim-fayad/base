<?php

namespace App\Traits\BaseService;

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
}

