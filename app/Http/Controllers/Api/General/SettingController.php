<?php

namespace App\Http\Controllers\Api\General;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Traits\PaginationTrait;
use App\Enums\TermsUserTypesEnum;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\Core\SettingService;


class SettingController extends Controller
{
    use ResponseTrait, PaginationTrait;

    public function __construct(private SettingService $settingService) {}

    public function about(): JsonResponse
    {
        $data = $this->settingService->getFixedPage(slug: 'about');
        return $this->jsonResponse(data: $data['content']);
    }

    public function whoWeAre(): JsonResponse
    {
        $data = $this->settingService->getFixedPage(slug: 'who_we_are');
        return $this->jsonResponse(data: $data['content']);
    }

    public function terms($type = TermsUserTypesEnum::USER->value): JsonResponse
    {
        $data = $this->settingService->getFixedPage(slug: $type);
        return $this->jsonResponse(data: $data['content']);
    }

    public function privacy(): JsonResponse
    {
        $data = $this->settingService->getFixedPage(slug: 'privacy');
        return $this->jsonResponse(data: $data['content']);
    }

    public function changeLang(Request $request): JsonResponse
    {
        $request->validate(['lang' => 'required|in:ar,en']);
        $data = $this->settingService->switchLang(request: $request, user: auth()->user());
        return $this->jsonResponse(msg: $data['msg']);
    }

    public function contactNumbers(): JsonResponse
    {
        $data = $this->settingService->getValueFromSetting('contact_numbers');
        return $this->jsonResponse(data: json_decode($data['data'], true));
    }
}
