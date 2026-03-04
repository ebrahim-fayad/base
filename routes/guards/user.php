<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\Auth\AuthController;
use App\Http\Controllers\Api\User\HomeController;
use App\Http\Controllers\Api\User\Meals\MealLogController;
use App\Http\Controllers\Api\User\Auth\ProfileController;
use App\Http\Controllers\Api\User\Meals\MealItemController;
use App\Http\Controllers\Api\User\Meals\MealTypeController;
use App\Http\Controllers\Api\User\Exercises\ProgramLevelController;
use App\Http\Controllers\Api\User\Auth\ForgetPasswordController;
use App\Http\Controllers\Api\User\Exercises\MyPlanController;
use App\Http\Controllers\Api\User\IncentivePoints\IncentivePointsController;

Route::group(['middleware' => ['guest:sanctum']], function () {
    // Routes here
    Route::group(['controller' => AuthController::class], function () {
        Route::post('login', 'login');
        Route::post('register', 'register');
        Route::post('complete-data', 'completeData');
        Route::post('resend-code', 'resendCode');
        Route::post('check-code', 'activate');
    });

    Route::group(['controller' => ForgetPasswordController::class], function () {
        Route::post('forget-password-send-code',        'forgetPasswordSendCode');
        Route::post('forget-password-check-code',       'forgetPasswordCheckCode');
        Route::post('reset-password',                   'resetPassword');
        Route::post('re-send-code',                     'forgetPasswordSendCode');
    });
});

Route::group(['middleware' => ['OptionalSanctumMiddleware']], function () {
    Route::get('home', [HomeController::class, 'index']);
    Route::get('meal-items', [MealItemController::class, 'index']);
});

Route::group(['middleware' => ['auth:user', 'is_blocked']], function () {

    Route::group(['controller' => ProfileController::class], function () {
        Route::prefix('profile')->group(function () {
            Route::get('/', 'profile');
            Route::patch('/update', 'update');
        });
        Route::post('change-password',  'changePassword');

        // update phone
        Route::group(['controller' => ProfileController::class, 'prefix' => 'change-phone'], function () {
            Route::post('send-code',                    'changePhoneSendCode');
            Route::post('new-phone-send-code',          'newPhoneSendCode');
            Route::post('check-code',                   'verifyCode');
        });
    });

    Route::controller(AuthController::class)->group(function () {
        Route::post('delete-account', 'deleteAccount');
        Route::post('logout', 'logout');
    });

    Route::group(['controller' => ProgramLevelController::class], function () { // Exercises
        Route::get('program-levels', 'index');
        Route::get('program-levels/{id}/show', 'show');
        Route::post('program-levels/{id}/subscribe', 'subscribe');
    });

    Route::group(['controller' => MyPlanController::class, 'prefix' => 'my-plans'], function () { // My-Plans
        Route::get('/', 'index');
        Route::get('/{id}/show', 'show');
        Route::post('/exercise-completion-rate', 'completionRate');
    });

    Route::get('incentive-points', [IncentivePointsController::class, 'index']);

    Route::prefix('meals')->group(function () {
        Route::get('types', [MealTypeController::class, 'index']);
        Route::get('items', [MealItemController::class, 'index']);

        Route::group(['controller' => MealLogController::class, 'prefix' => 'macros'], function () {
            Route::get('/', 'index');
            Route::post('/', 'store');
        });
    });
});
