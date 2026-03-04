<?php

use App\Http\Controllers\Api\User\AuthController;
use App\Http\Controllers\Api\User\CategoryController;
use App\Http\Controllers\Api\User\ProfileController;
use App\Http\Controllers\Api\User\Home\HomeController;
use App\Http\Controllers\Api\User\ServiceController;
use App\Http\Controllers\Api\User\Orders\OrderController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['guest:sanctum']], function () {
    // Routes here
    Route::group([ 'controller' => AuthController::class], function () {
        Route::post('login', 'login');
        Route::post('resend-code', 'resendCode');
        Route::post('activate', 'activate');
        Route::post('register', 'register');
        Route::post('check-code', 'checkCode');
    });
});

Route::group(['middleware' => ['OptionalSanctumMiddleware',]], function () {
    Route::controller(HomeController::class)->group(function () {
        Route::get('home', 'index');
        Route::post('home-filter', 'homeFilter');
        Route::get('providers', 'getProviders');
        Route::get('categories', 'categories');
        Route::get('type-services', 'typeServices');
        Route::get('services', 'services');
        Route::get('partners', 'partners');
    });
    Route::controller(CategoryController::class)->group(function () {
        Route::get('type-services/{parent_id}', 'getTypeServicesByMainCategory');
    });
    Route::controller(ServiceController::class)->group(function () {
        Route::get('services/{type_service_id}', 'getServicesByTypeService');
        Route::get('services/type-audience/{type_audience_id}', 'getServicesByTypeAudience');
        Route::get('services/show/{service_id}', 'show');
    });
});

Route::group(['middleware' => ['auth:user', 'is_blocked']], function () {
    // Routes here
    Route::controller(AuthController::class)->group(function () {
        Route::post('delete-account', 'deleteAccount');
        Route::post('logout', 'logout');
    });
    Route::group(['controller' => ProfileController::class], function () {
        Route::prefix('profile')->group(function () {
            Route::get('/', 'profile');
            Route::patch('update', 'update');
        });
        Route::prefix('change-phone')->group(function () {
            Route::post('send-code', 'changePhoneSendCode');
            Route::post('check-code', 'verifyCode');
            Route::post('new-phone-send-code', 'newPhoneSendCode');
         });
    });
    Route::group(['prefix' => 'orders','controller' => OrderController::class], function () {
        Route::get('/{type}', 'index');
        Route::post('/create-order', 'store');
        Route::get('/show/{order_id}', 'show');
        Route::post('/order-summary', 'orderSummary');
        Route::post('/order-complaint/{order_id}', 'orderComplaint');
    });

    Route::middleware('MustCompleteData')->group(function () {

    });
});
