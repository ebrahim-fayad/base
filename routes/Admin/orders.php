<?php

use Illuminate\Support\Facades\Route;

$controller = 'Orders\OrderController';
/*------------ start Of orders ----------*/
Route::get('all-orders', [
    'as' => 'all-orders',
    'icon' => '<i class="feather icon-shopping-cart"></i>',
    'title' => 'orders.index',
    'type' => 'parent',
    'has_sub_route' => true,
    'child' => [
        'orders.new',
        'orders.current',
        'orders.finished',
        'orders.cancelled',
        'orders.show',
    ],
]);
Route::get('orders/new', [
    'uses' => $controller . '@newOrders',
    'as' => 'orders.new',
    'title' => 'orders.new_orders',
    'sub_link' => true,
]);

Route::get('orders/current', [
    'uses' => $controller . '@currentOrders',
    'as' => 'orders.current',
    'title' => 'orders.current_orders',
    'sub_link' => true,
]);

Route::get('orders/finished', [
    'uses' => $controller . '@finishedOrders',
    'as' => 'orders.finished',
    'title' => 'orders.finished_orders',
    'sub_link' => true,
]);

Route::get('orders/cancelled', [
    'uses' => $controller . '@cancelledOrders',
    'as' => 'orders.cancelled',
    'title' => 'orders.cancelled_orders',
    'sub_link' => true,
]);

# orders show
Route::get(
    'orders/{id}/Show',
    [
        'uses' => $controller . '@show',
        'as' => 'orders.show',
        'title' => 'orders.show',
    ]
);

# extend order time
Route::post(
    'orders/{id}/extend-time',
    [
        'uses' => $controller . '@extendTime',
        'as' => 'orders.extend-time',
        'title' => 'orders.extend_time',
    ]
);
