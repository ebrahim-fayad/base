<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\General\SettingController;
use App\Http\Controllers\Api\General\MealTypeController;

Route::group(['middleware' => ['OptionalSanctumMiddleware']], function () {

    Route::controller(SettingController::class)->group(function () {
        // change language
        Route::get('change-lang', 'changeLang');
        Route::get('about', 'about');
        Route::get('who-we-are', 'whoWeAre');
        Route::get('privacy-policy', 'privacy');
        // get terms and conditions
        Route::get('terms/{type}', 'terms');
    });


    // New Routes here
});


Route::group(['middleware' => ['auth:sanctum', 'is_blocked']], function () {
    require __DIR__ . '/../Api/notification.php';
    // Routes here
});
