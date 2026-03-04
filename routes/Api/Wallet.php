<?php

use App\Http\Controllers\Api\General\WalletController;
use Illuminate\Support\Facades\Route;

// wallet
Route::group(['controller' => WalletController::class, 'prefix' => 'wallet'], function () {
    Route::get('', 'show');
    Route::post('charge', 'charge');
});
// wallet
