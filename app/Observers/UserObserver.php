<?php

namespace App\Observers;

use App\Enums\UserTypesEnum;
use App\Models\AllUsers\User;

class UserObserver
{

    public function deleted($model): void
    {
        $model->deleteFile($model->getRawOriginal('image'), User::IMAGEPATH);
        $model->tokens()->delete();
        $model->devices()->delete();
    }
}
