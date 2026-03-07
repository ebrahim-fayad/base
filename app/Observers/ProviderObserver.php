<?php

namespace App\Observers;

use App\Models\AllUsers\Provider;


class ProviderObserver
{

    public function created($model): void
    {
        $model->wallet()->create([
            'balance'           => 0,
            'available_balance' => 0
        ]);
    }



    public function deleted($model): void
    {
        $model->deleteFile($model->getRawOriginal('commercial_image'), Provider::IMAGEPATH);
        $model->deleteFile($model->getRawOriginal('image'), Provider::IMAGEPATH);
        $model->tokens()->delete();
        $model->devices()->delete();
        $model->wallet()->delete();
        $model->updateRequest()->delete();
    }
}
