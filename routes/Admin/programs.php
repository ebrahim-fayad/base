<?php

use Routes\Admin\Programs\ProgramsRoutesName;
use Illuminate\Support\Facades\Route;

Route::get('levels-management', [
    'as'            => 'levels-management',
    'icon'          => '<i class="feather icon-activity"></i>',
    'title'         => 'levels_management',
    'type'          => 'parent',
    'has_sub_route' => true,
    'child'         => ProgramsRoutesName::getNames(),
]);

require __DIR__ . '/Programs/routes-links.php';
