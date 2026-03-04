<?php

use Illuminate\Support\Facades\Route;

Route::get('incentive-points', [
    'as'            => 'incentive_points',
    'icon'          => '<i class="feather icon-award"></i>',
    'title'         => 'incentive_points',
    'type'          => 'parent',
    'has_sub_route' => true,
    'child'         => ['incentive_points.reports'],
]);

Route::get('incentive-points/reports', [
    'uses'     => 'IncentivePoints\PointsReportsController@index',
    'as'       => 'incentive_points.reports',
    'title'    => 'incentive_points_reports',
    'sub_link' => true,
]);

Route::get('incentive-points/reports/export-pdf', [
    'uses'  => 'IncentivePoints\PointsReportsController@exportPdf',
    'as'    => 'incentive_points.reports.exportPdf',
    'title' => 'incentive_points.reports.exportPdf',
]);
