<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Provider\SettlementController;

// Settlements
Route::group([
    'controller' => SettlementController::class,
    'prefix' => 'settlements',
], function () {
    Route::post('create', 'create');
    Route::get('due/settlement', 'financialTransactions');
    Route::get('{id}/details', 'show');
    Route::get('{status}', 'index');
});
