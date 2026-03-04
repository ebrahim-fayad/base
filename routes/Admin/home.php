<?php

use Illuminate\Support\Facades\Route;

/*------------ start Of Home----------*/

Route::get('dashboard', [
    'uses'         => 'HomeController@dashboard',
    'as'           => 'dashboard',
    'icon'         => '<i class="feather icon-home"></i>',
    'title'        => 'main_page',
    'has_sub_route' => false,
])->middleware('auth:admin');

Route::get('dashboard/export/excel', [
    'uses' => 'HomeController@exportExcel',
    'as'   => 'dashboard.export.excel',
])->middleware('auth:admin');

Route::get('dashboard/export/pdf', [
    'uses' => 'HomeController@exportPdf',
    'as'   => 'dashboard.export.pdf',
])->middleware('auth:admin');
