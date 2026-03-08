<?php

use Illuminate\Support\Facades\Route;


Route::group(['as' => 'admin.', 'namespace' => 'App\Http\Controllers\Admin'], function () {
    Route::prefix('admin')->group(function () {
        require __DIR__ . '/Admin/auth.php';
        Route::middleware('is_blocked')->group(function () {
        require __DIR__ . '/Admin/home.php';
        require __DIR__ . '/Admin/profile.php';
        });
        Route::middleware(['admin','is_blocked'])->group(function () {
            require __DIR__ . '/Admin/all_users.php';
            require __DIR__ . '/Admin/intro.php';
            require __DIR__ . '/Admin/public-settings.php';
            require __DIR__ . '/Admin/public-sections.php';
            require __DIR__ . '/Admin/categories.php';
            require __DIR__ . '/Admin/levels.php';
            require __DIR__ . '/Admin/partners.php';
            require __DIR__ . '/Admin/orders.php';
            require __DIR__ . '/Admin/settlements.php';
            // require __DIR__ . '/Admin/countries-cities.php';
            require __DIR__ . '/Admin/notifications.php';
            require __DIR__ . '/Admin/pages.php';
        });

        // Set Language For Admin
        Route::get('/lang/{lang}', 'Core\AuthController@SetLanguage');
    });

    Route::get('export/columns', 'Core\ExcelController@columns')->name('master-export.columns');
    Route::get('export', 'Core\ExcelController@master')->name('master-export');
    Route::post('import-items', 'Core\ExcelController@importItems')->name('import-items');
});
