<?php

namespace App\Http\Controllers\Api\General;

use App\Enums\TermsUserTypesEnum;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use App\Models\PublicSections\Fqs;
use App\Http\Controllers\Controller;
use App\Models\PublicSections\Image;
use App\Models\PublicSections\Intro;
use App\Models\PublicSettings\Social;
use App\Services\Core\SettingService;
use App\Http\Resources\Api\General\Settings\FqsResource;
use App\Http\Resources\Api\General\Settings\ImageResource;
use App\Http\Resources\Api\General\Settings\IntroResource;
use App\Http\Resources\Api\General\Settings\SocialResource;

class SettingController extends Controller
{
    use ResponseTrait;

    public function __construct(private SettingService $settingService) {}

    public function about(): JsonResponse
    {
        $data = $this->settingService->getFixedPage(slug: 'about');
        return $this->jsonResponse(msg: __('apis.data_retrieved_successfully'), data: $data['content']);
    }

    public function whoWeAre(): JsonResponse
    {
        $data = $this->settingService->getFixedPage(slug: 'who_we_are');
        return $this->jsonResponse(msg: __('apis.data_retrieved_successfully'), data: $data['content']);
    }

    public function terms($type = TermsUserTypesEnum::INDIVIDUAL->value): JsonResponse
    {
        $data = $this->settingService->getFixedPage(slug: $type);
        return $this->jsonResponse(msg: __('apis.data_retrieved_successfully'), data: $data['content']);
    }

    public function privacy(): JsonResponse
    {
        $data = $this->settingService->getFixedPage(slug: 'privacy');
        return $this->jsonResponse(msg: __('apis.data_retrieved_successfully'), data: $data['content']);
    }

    public function splashPages(): JsonResponse
    {
        $data = $this->settingService->getAppMenu(Intro::class);
        return $this->jsonResponse(msg: __('apis.data_retrieved_successfully'), data: IntroResource::collection($data['rows']));
    }

    public function fqs(): JsonResponse
    {
        $data = $this->settingService->getAppMenu(Fqs::class);
        return $this->jsonResponse(msg: __('apis.data_retrieved_successfully'), data: FqsResource::collection($data['rows']));
    }

    public function socials(): JsonResponse
    {
        $data = $this->settingService->getAppMenu(Social::class);
        return $this->jsonResponse(msg: __('apis.data_retrieved_successfully'), data: SocialResource::collection($data['rows']));
    }

    public function sliders(): JsonResponse
    {
        $data = $this->settingService->getAppMenu(Image::class);
            return $this->jsonResponse(msg: __('apis.data_retrieved_successfully'), data: ImageResource::collection($data['rows']));
    }

    public function changeLang(Request $request): JsonResponse
    {
        $request->validate(['lang' => 'required|in:ar,en','device_id'=>'required|string']);
        $data = $this->settingService->switchLang(request: $request, user: auth()->user());
        return $this->jsonResponse(msg: $data['msg'], data: [] );
    }
}
