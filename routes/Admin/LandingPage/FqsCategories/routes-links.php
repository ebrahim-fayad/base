<?php

use Illuminate\Support\Facades\Route;

/*------------ start Of introfqscategories ----------*/

$controller = 'LandingPage\IntroFqsCategoryController';
Route::get('introfqscategories', [
    'uses'  => $controller . '@index',
    'as'    => 'introfqscategories.index',
    'title' => 'common_questions_sections.index',
    'sub_link'  => true,
]);
# socials store
Route::get('introfqscategories/create', [
    'uses'  => $controller . '@create',
    'as'    => 'introfqscategories.create',
    'title' => 'common_questions_sections.create_page',
]);
# introfqscategories store
Route::post('introfqscategories/store', [
    'uses'  => $controller . '@store',
    'as'    => 'introfqscategories.store',
    'title' => 'common_questions_sections.create',
]);
# introfqscategories update
Route::get('introfqscategories/{id}/edit', [
    'uses'  => $controller . '@edit',
    'as'    => 'introfqscategories.edit',
    'title' => 'common_questions_sections.edit_page',
]);
# introfqscategories update
Route::put('introfqscategories/{id}', [
    'uses'  => $controller . '@update',
    'as'    => 'introfqscategories.update',
    'title' => 'common_questions_sections.edit',
]);

# introfqscategories update
Route::get('introfqscategories/{id}/Show', [
    'uses'  => $controller . '@show',
    'as'    => 'introfqscategories.show',
    'title' => 'common_questions_sections.show',
]);

# introfqscategories delete
Route::delete('introfqscategories/{id}', [
    'uses'  => $controller . '@destroy',
    'as'    => 'introfqscategories.delete',
    'title' => 'common_questions_sections.delete',
]);

#delete all introfqscategories
Route::post('delete-all-introfqscategories', [
    'uses'  => $controller . '@destroyAll',
    'as'    => 'introfqscategories.deleteAll',
    'title' => 'common_questions_sections.delete_all',
]);
/*------------ end Of introfqscategories ----------*/
