<?php

use Illuminate\Support\Facades\Route;

Route::get('subscriptions', [
    'uses'          => 'Subscriptions\SubscriptionController@index',
    'as'            => 'subscriptions',
    'icon'          => '<i class="feather icon-calendar"></i>',
    'title'         => 'subscriptions',
    'type'          => 'parent',
    'has_sub_route' => false,
]);
