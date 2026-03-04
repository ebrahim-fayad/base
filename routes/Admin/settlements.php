<?php

use Illuminate\Support\Facades\Route;

$controller = 'Settlements\SettlementController';
/*------------ start Of Settlements----------*/
Route::get('settlements', [
    'uses' => $controller . '@index',
    'as' => 'settlements.index',
    'title' => 'settlement_requests',
    'icon' => '<i class="feather icon-image"></i>',
    'type' => 'parent',
    'has_sub_route' => false,
    'child' => [
        'settlements.show',
        'settlements.changeStatus',
    ],
]);

#Show Settlement
Route::get('settlements/show/{id}', [
    'uses' => $controller . '@show',
    'as' => 'settlements.show',
    'title' => 'view_settlement_order',
]);

#Change Settlement Status
Route::post('settlements/change-status', [
    'uses' => $controller . '@settlementChangeStatus',
    'as' => 'settlements.changeStatus',
    'title' => 'change_status_settlement_requests',
]);
/*------------ end Of Settlements ----------*/

