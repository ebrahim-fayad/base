<?php

use Illuminate\Support\Facades\Route;


Route::group(['as' => 'admin.', 'namespace' => 'App\Http\Controllers\Admin'], function () {
    Route::prefix('admin')->group(function () {
        require __DIR__ . '/Admin/auth.php';
        require __DIR__ . '/Admin/home.php';
        require __DIR__ . '/Admin/profile.php';

        Route::middleware('admin')->group(function () {
            require __DIR__ . '/Admin/all_users.php';
            require __DIR__ . '/Admin/programs.php';
            require __DIR__ . '/Admin/meal-types.php';
            require __DIR__ . '/Admin/meal-items.php';
            require __DIR__ . '/Admin/intro.php';
            require __DIR__ . '/Admin/public-settings.php';
            require __DIR__ . '/Admin/analytics.php';
            require __DIR__ . '/Admin/incentive-points.php';
            require __DIR__ . '/Admin/notifications.php';
            require __DIR__ . '/Admin/subscriptions.php';
            // require __DIR__ . '/Admin/pages.php';
        });

        // Set Language For Admin
        Route::get('/lang/{lang}', 'AuthController@SetLanguage');
    });

    Route::get('export/{export}', 'Core\ExcelController@master')->name('master-export');
    Route::post('import-items', 'Core\ExcelController@importItems')->name('import-items');
});
