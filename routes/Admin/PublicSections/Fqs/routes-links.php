<?php

use Illuminate\Support\Facades\Route;

/*------------ start Of fqs ----------*/

$controller = 'PublicSections\FqsController';
Route::get('fqs', [
    'uses'     => $controller . '@index',
    'as'       => 'fqs.index',
    'sub_link' => true,
    'title'    => 'questions_sections.index',
]);

Route::get('fqs/{id}/show', [
    'uses'  => $controller . '@show',
    'as'    => 'fqs.show',
    'title' => 'questions_sections.show',
]);

# fqs store
Route::get('fqs/create', [
    'uses'  => $controller . '@create',
    'as'    => 'fqs.create',
    'title' => 'questions_sections.create_page',
]);

# fqs store
Route::post('fqs/store', [
    'uses'  => $controller . '@store',
    'as'    => 'fqs.store',
    'title' => 'questions_sections.create',
]);

# fqs update
Route::get('fqs/{id}/edit', [
    'uses'  => $controller . '@edit',
    'as'    => 'fqs.edit',
    'title' => 'questions_sections.edit_page',
]);

# fqs update
Route::put('fqs/{id}', [
    'uses'  => $controller . '@update',
    'as'    => 'fqs.update',
    'title' => 'questions_sections.edit',
]);

# fqs delete
Route::delete('fqs/{id}', [
    'uses'  => $controller . '@destroy',
    'as'    => 'fqs.delete',
    'title' => 'questions_sections.delete',
]);
#delete all fqs
Route::post('delete-all-fqs', [
    'uses'  => $controller . '@destroyAll',
    'as'    => 'fqs.deleteAll',
    'title' => 'questions_sections.delete_all',
]);
/*------------ end Of fqs ----------*/
