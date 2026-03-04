<?php

namespace Routes\Admin\CountriesCities\Cities;

class CitiesRoutesName
{
    public static function getNames(): array
    {
        return [
            // cities routes
            'cities.index',
            'cities.create',
            'cities.store',
            'cities.edit',
            'cities.show',
            'cities.update',
            'cities.delete',
            'cities.deleteAll',
        ];
    }
}
