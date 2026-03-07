<?php

namespace App\Http\Controllers\Admin\PublicSettings;

use App\Http\Controllers\Admin\Core\AdminBasicController;
use App\Models\PublicSettings\Social;
use App\Http\Requests\Admin\PublicSettings\Socials\StoreRequest;
use App\Services\Core\BaseService;

class SocialController extends AdminBasicController
{

    public function __construct()
    {
        $this->model = Social::class;
        $this->storeRequest = StoreRequest::class;
        $this->updateRequest = StoreRequest::class;
        $this->directoryName = 'public-settings.socials';
        $this->serviceName = new BaseService(Social::class);
        $this->indexScopes = 'search';
    }

    // social has observer to Cache::forget('socials'); when created, updated, deleted
}
