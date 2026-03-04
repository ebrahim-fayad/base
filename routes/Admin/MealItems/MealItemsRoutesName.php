<?php

namespace Routes\Admin\MealItems;

class MealItemsRoutesName
{
    public static function getNames(): array
    {
        return [
            'meal_analytics.index',
            'meal_items.index',
            'meal_items.show',
            'meal_items.create',
            'meal_items.store',
            'meal_items.edit',
            'meal_items.update',
            'meal_items.delete',
            'meal_items.deleteAll',
        ];
    }
}
