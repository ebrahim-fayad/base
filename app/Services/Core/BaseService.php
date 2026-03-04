<?php

namespace App\Services\Core;

use App\Traits\UploadTrait;
use App\Traits\BaseService\QueryTrait;
use App\Traits\BaseService\CrudTrait;
use App\Traits\BaseService\RelationTrait;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BaseService\FileNotificationTrait;

class BaseService
{
    use UploadTrait;
    use QueryTrait;
    use CrudTrait;
    use RelationTrait;
    use FileNotificationTrait;

    protected $model;

    public function __construct($model = null)
    {
        $this->model = $model;
    }

    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    // Wesam contributions to update pivot row in many to many relationship
    public function updatePivot(string $relation, Model $model, int $id, array $data): array
    {
        try {
            $model->$relation()->updateExistingPivot($id, $data);
            return ['key' => 'success', 'msg' => __('apis.success'), 'data' => $model];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    // Wesam contributions to get pivot data for a row in many to many relationship
    public function getPivotRelation(string $relation, Model $model, int $id, array $with = []): object
    {
        try {
            return $model->$relation()->with($with)->findOrFail($id);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }


    // Wesam contributions to detach row or multiple rows in many to many relationship
    public function detachRelation(string $relation, Model $model, array|int $id): array
    {
        try {
            $model->$relation()->detach($id);
            return ['key' => 'success', 'msg' => __('apis.success'), 'data' => $model];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
