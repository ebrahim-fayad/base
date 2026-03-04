<?php

use Illuminate\Support\Facades\Route;
use Routes\Admin\MealItems\MealItemsRoutesName;

Route::get('meal-items-management', [
    'as'            => 'meal-items-management',
    'icon'          => '<i class="ficon feather icon-package"></i>',
    'title'         => 'meal_items_management',
    'type'          => 'parent',
    'has_sub_route' => true,
    'child'         => MealItemsRoutesName::getNames(),
]);

require __DIR__ . '/MealItems/routes-links.php';
