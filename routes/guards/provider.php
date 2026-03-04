<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Provider\AuthController;
use App\Http\Controllers\Api\Provider\HomeController;
use App\Http\Controllers\Api\Provider\OrderController;
use App\Http\Controllers\Api\Provider\ProfileController;
use App\Http\Controllers\Api\Provider\Services\ServiceController;
use App\Http\Controllers\Api\Provider\Categories\CategoryController;
use App\Http\Controllers\Api\Provider\ProviderAppointmentController;
Route::group(['middleware' => ['guest:provider']], function () {
    // Routes here
    Route::group(['controller' => AuthController::class], function () {
        Route::post('login', 'login');
        Route::post('register', 'register');
        Route::post('resend-activate-code', 'resendCode');
        Route::post('resend-code', 'resendCode');
        Route::post('activate', 'activate');
        Route::post('check-code', 'checkCode');
    });


});

Route::group(['middleware' => ['auth:provider', 'api_is_blocked', 'api_is_approved']], function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('delete-account', 'deleteAccount');
        Route::post('logout', 'logout');
    });
    Route::group(['prefix' => 'categories', 'controller' => CategoryController::class], function () {
        Route::get('/', 'index');
        Route::get('/{category_id}/services-type', 'servicesType');
    });
    Route::group(['prefix' => 'services', 'controller' => ServiceController::class], function () {
        Route::get('/', 'index');
        Route::post('/store', 'create');
        Route::put('/{service_id}', 'update');
        Route::delete('/{service_id}', 'delete');
        Route::delete('/image/{serviceImage}', 'deleteImage');
    });
    Route::get('target-audiences', [\App\Http\Controllers\Api\User\Home\HomeController::class, 'targetAudiences']);
    Route::group(['controller' => ProfileController::class], function () {
        Route::prefix('profile')->group(function () {
            Route::get('/', 'profile');
            Route::put('update', 'update');
        });
        Route::prefix('change-phone')->group(function () {
            Route::post('send-code', 'changePhoneSendCode');
            Route::post('check-code', 'verifyCode');
            Route::post('new-phone-send-code', 'newPhoneSendCode');
        });
    });


    Route::group(['prefix' => 'appointments', 'controller' => ProviderAppointmentController::class], function () {
        Route::get('/', 'index');
        Route::put('/{appointment_id}', 'update');
        Route::patch('/toggle-open/{appointment_id}', 'toggleOpen');
    });
    // Dashboard
    Route::group(['prefix' => 'home', 'controller' => HomeController::class], function () {
        Route::get('/', 'index');
        Route::get('/chart', 'chart');
    });
    Route::group(['prefix' => 'orders', 'controller' => OrderController::class], function () {
        Route::get('/{type}', 'index');
        Route::get('/show/{order_id}', 'show');
        Route::patch('/confirm/{order_id}', 'confirm')->name('orders.confirm');
    });


});
