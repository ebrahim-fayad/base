<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Core\AuthController;


// guest routes for admin
Route::controller(AuthController::class)->group(function () {
    Route::group(['middleware' => ['guest:admin'], 'prefix' => 'login'], function () {
        Route::get('', 'showLoginForm')->name('show.login');
        Route::post('', 'login')->name('login');
        Route::fallback(function () {
            return redirect()->route('admin.show.login');
        });
    });
    Route::get('logout', 'logout')->name('logout')->middleware('auth:admin');
});
