<?php

use Illuminate\Support\Facades\Route;

/*------------ start Of introfqs ----------*/

$controller = 'LandingPage\IntroFqsController';
Route::get('introfqs', [
    'uses'  => $controller . '@index',
    'as'    => 'introfqs.index',
    'title' => 'questions_sections.index',
    'sub_link'  => true,
]);

# socials store
Route::get('introfqs/create', [
    'uses'  => $controller . '@create',
    'as'    => 'introfqs.create',
    'title' => 'questions_sections.create_page',
]);

# introfqs store
Route::post('introfqs/store', [
    'uses'  => $controller . '@store',
    'as'    => 'introfqs.store',
    'title' => 'questions_sections.create',
]);
# introfqscategories update
Route::get('introfqs/{id}/edit', [
    'uses'  => $controller . '@edit',
    'as'    => 'introfqs.edit',
    'title' => 'questions_sections.edit_page',
]);
# introfqscategories update
Route::get('introfqs/{id}/Show', [
    'uses'  => $controller . '@show',
    'as'    => 'introfqs.show',
    'title' => 'questions_sections.show',
]);

# introfqs update
Route::put('introfqs/{id}', [
    'uses'  => $controller . '@update',
    'as'    => 'introfqs.update',
    'title' => 'questions_sections.edit',
]);

# introfqs delete
Route::delete('introfqs/{id}', [
    'uses'  => $controller . '@destroy',
    'as'    => 'introfqs.delete',
    'title' => 'questions_sections.delete',
]);

#delete all introfqs
Route::post('delete-all-introfqs', [
    'uses'  => $controller . '@destroyAll',
    'as'    => 'introfqs.deleteAll',
    'title' => 'questions_sections.delete_all',
]);
/*------------ end Of introfqs ----------*/
