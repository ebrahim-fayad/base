<?php

use Illuminate\Support\Facades\Route;

Route::get('analytics', [
    'as'            => 'analytics',
    'icon'          => '<i class="feather icon-bar-chart-2"></i>',
    'title'         => 'analytics_reports',
    'type'          => 'parent',
    'has_sub_route' => true,
    'child'         => ['analytics.index'],
]);

Route::get('analytics/reports', [
    'uses'  => 'Analytics\AnalyticsController@index',
    'as'    => 'analytics.index',
    'title' => 'analytics_reports',
    'sub_link' => true,
]);

Route::get('analytics/export/users-pdf', [
    'uses'  => 'Analytics\AnalyticsController@exportUsersPdf',
    'as'    => 'analytics.export.usersPdf',
    'title' => 'analytics.export.usersPdf',
]);

Route::get('analytics/export/subscriptions-pdf', [
    'uses'  => 'Analytics\AnalyticsController@exportSubscriptionsPdf',
    'as'    => 'analytics.export.subscriptionsPdf',
    'title' => 'analytics.export.subscriptionsPdf',
]);

Route::get('analytics/export/points-pdf', [
    'uses'  => 'Analytics\AnalyticsController@exportPointsPdf',
    'as'    => 'analytics.export.pointsPdf',
    'title' => 'analytics.export.pointsPdf',
]);
