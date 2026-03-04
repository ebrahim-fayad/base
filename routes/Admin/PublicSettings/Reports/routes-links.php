<?php

use Illuminate\Support\Facades\Route;

/*------------ start Of reports----------*/

$controller = 'PublicSettings\ReportController';
Route::get('reports', [
    'uses'     => $controller . '@index',
    'as'       => 'reports',
    'sub_link' => true,
    'title'    => 'reports.index',
]);

# reports show
Route::get('reports/{id}', [
    'uses'  => $controller . '@show',
    'as'    => 'reports.show',
    'title' => 'reports.show',
]);
# reports delete
Route::delete('reports/{id}', [
    'uses'  => $controller . '@destroy',
    'as'    => 'reports.delete',
    'title' => 'reports.delete',
]);

#delete all reports
Route::post('delete-all-reports', [
    'uses'  => $controller . '@destroyAll',
    'as'    => 'reports.deleteAll',
    'title' => 'reports.delete_all',
]);
/*------------ end Of reports ----------*/
