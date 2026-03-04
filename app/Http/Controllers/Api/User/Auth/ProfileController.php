<?php

namespace App\Http\Controllers\Api\User\Auth;


use App\Models\AllUsers\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Enums\AuthUpdatesAttributesEnum;
use App\Services\Profile\ProfileService;
use App\Http\Resources\Api\User\UserResource;
use App\Http\Requests\Api\User\Profile\NewPhoneRequest;
use App\Http\Requests\Api\User\Profile\VerifyCodeRequest;
use App\Http\Requests\Api\User\Profile\UpdateProfileRequest;
use App\Http\Requests\Api\User\Profile\ChangePasswordRequest;

class ProfileController extends Controller
{
    use ResponseTrait;

    private $profileService;

    public function __construct()
    {
        $this->profileService = new ProfileService(User::class);
    }

    public function profile(): JsonResponse
    {
        return $this->jsonResponse(data: UserResource::make(auth('user')->user()));
    }

    public function update(UpdateProfileRequest $request): JsonResponse
    {
        try {
            DB::transaction(function () use ($request) {
                $this->profileService->update(id: auth('user')->id(), data: $request->validated());
            });
            return $this->jsonResponse(msg: __('apis.updated'),data: UserResource::make(auth('user')->user()->refresh()));
        } catch (\Exception $e) {
            log_error($e);
            return $this->jsonResponse(__('apis.something_went_wrong'));
        }
    }

    // change user phone
    public function changePhoneSendCode(): JsonResponse
    {
        $data = [
            'user' => auth('user')->user(),
            'type' => AuthUpdatesAttributesEnum::Phone,
            'attribute' => auth('user')->user()->phone,
            'country_code' => auth('user')->user()->country_code
        ];
        $result = $this->profileService
            ->storeAtUpdates(request: $data);
        return $this->jsonResponse(msg: $result['msg'], data: $result['data']);
    }

    public function newPhoneSendCode(NewPhoneRequest $request): JsonResponse
    {
        $result = $this->profileService
            ->storeAtUpdates(request: $request->validated());
        return $this->jsonResponse(msg: $result['msg'], data: $result['data']);
    }

    protected function verifyCode(VerifyCodeRequest $request): JsonResponse
    {
        $result = $this->profileService->verifyCode(user: auth('user')->user(), request: $request);
        return $this->jsonResponse(msg:$result['msg']);
    }

    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        try {
            DB::transaction(function () use ($request) {
                return $this->profileService->update(id: auth('user')->id(), data: $request->only('password'));
            });
            return $this->jsonResponse(msg: __('apis.password_updated'));
        } catch (\Exception $e) {
            log_error($e);
            throw new \Exception(__('apis.something_went_wrong'));
        }
    }
}
