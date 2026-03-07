<?php

namespace App\Observers;

use App\Enums\UserTypesEnum;
use App\Models\AllUsers\User;

class UserObserver
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
        $model->tokens()->delete();
        $model->devices()->delete();
        $model->wallet()->delete();
    }
}
