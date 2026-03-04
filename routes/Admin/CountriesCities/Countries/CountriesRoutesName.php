<?php

namespace Routes\Admin\CountriesCities\Countries;

class CountriesRoutesName
{
    public static function getNames(): array
    {
        return [
            // countries routes
            'countries.index',
            'countries.show',
            'countries.create',
            'countries.store',
            'countries.edit',
            'countries.update',
            'countries.delete',
            'countries.deleteAll',
        ];
    }
}
