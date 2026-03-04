<?php

namespace App\Http\Controllers\Admin\CountriesCities;

use App\Models\CountryCity\Country;
use Illuminate\Support\Facades\Route;
use App\Services\CountryCities\CountryService;
use App\Http\Controllers\Admin\Core\AdminBasicController;
use App\Http\Requests\Admin\CountriesCities\Country\StoreRequest;
use App\Http\Requests\Admin\CountriesCities\Country\UpdateRequest;

class CountryController extends AdminBasicController
{
    public function __construct()
    {

        $this->model = Country::class;
        $this->storeRequest = StoreRequest::class;
        $this->updateRequest = UpdateRequest::class;
        $this->directoryName = 'countries';
        $this->serviceName = new CountryService();
        $this->indexScopes = 'search';
        if (Route::currentRouteName() == 'admin.countries.create') {
            $this->createCompactVariables = ['flags' => $this->serviceName->getFlags()];
        }
        if (Route::currentRouteName() == 'admin.countries.edit') {
            $this->editCompactVariables = ['flags' => $this->serviceName->getFlags()];
        }
        $this->indexConditions = [];
        $this->destroyRelationsToCheck = ['users', 'entities', 'cities'];
    }
}
