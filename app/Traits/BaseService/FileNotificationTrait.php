<?php

namespace App\Traits\BaseService;

use Illuminate\Support\Facades\Notification;

trait FileNotificationTrait
{
    public function uploadMultiFiles($requestedImageToUpload, $modelImagePath, $key = null): array
    {
        try {
            $multiImages = [];
            if (count($requestedImageToUpload) > 0) {
                $multiImages = array_map(function ($singleImage) use ($key, $modelImagePath) {
                    return $key
                        ? [$key => $this->uploadAllTypes($singleImage, $modelImagePath)]
                        : $this->uploadAllTypes($singleImage, $modelImagePath);
                }, $requestedImageToUpload);
            }

            return $multiImages;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function sendNotification($data)
    {
        try {
            $classData = [
                'type' => $data['type'],
                'data' => isset($data['model_id']) ? $this->prepareNotificationData($data['model_id']) : []
            ];
            Notification::send($data['user'], new $data['class'](data: $classData));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    private function prepareNotificationData($id)
    {
        return ['class' => $this->model, 'id' => $id];
    }
}

