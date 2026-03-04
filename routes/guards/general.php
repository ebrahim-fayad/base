<?php

use App\Http\Controllers\Api\General\ComplaintController;
use App\Http\Controllers\Api\General\CountriesCitiesController;
use App\Http\Controllers\Api\General\SettingController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['OptionalSanctumMiddleware']], function () {
    Route::controller(SettingController::class)->group(function () {
        // change language
        Route::patch('change-lang', 'changeLang');
        // get terms and conditions
        Route::get('terms/{type}', 'terms');
            Route::get('sliders', 'sliders');
            // get about
            Route::get('about', 'about');
            // get who we are
            Route::get('who-we-are', 'whoWeAre');
            // get terms and conditions
            Route::get('terms/{type}', 'terms');
            // get privacy policy
            Route::get('privacy-policy', 'privacy');
    });

    // get countries and cities list
    Route::group(['prefix' => 'countries', 'controller' => CountriesCitiesController::class], function () {
        // get countries
        Route::get('', [CountriesCitiesController::class, 'getCountries']);
        // get cities of specific country
        Route::get('{country_id}/cities', [CountriesCitiesController::class, 'getCountryCities']);
    });

    Route::controller(ComplaintController::class)->group(function () {
        Route::post('contact-us', 'storeContactUs');
        Route::prefix('complaints')->group(function () {
            Route::get('/{status?}', 'index')->middleware('auth:sanctum');
            Route::post('/store', 'store');
            Route::get('/show/{id}', 'show')->middleware('auth:sanctum');
        });
    });

    // New Routes here
});


Route::group(['middleware' => ['auth:sanctum', 'is_blocked']], function () {
    require __DIR__ . '/../Api/notification.php';
    require __DIR__ . '/../Api/Wallet.php';
    require __DIR__ . '/../Api/settlement.php';
    // Routes here
});
