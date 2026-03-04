<?php

use Illuminate\Support\Facades\Route;
use Routes\Admin\MealTypes\MealTypesRoutesName;

Route::get('meal-types-management', [
    'as'            => 'meal-types-management',
    'icon'          => '<i class="feather icon-clipboard"></i>',
    'title'         => 'meal_types_management',
    'type'          => 'parent',
    'has_sub_route' => true,
    'child'         => MealTypesRoutesName::getNames(),
]);

require __DIR__ . '/MealTypes/routes-links.php';
