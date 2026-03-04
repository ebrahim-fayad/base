<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\ForgetPassword\ForgetPasswordCheckCodeRequest;
use App\Http\Requests\Api\User\ForgetPassword\ForgetPasswordSendCodeRequest;
use App\Http\Requests\Api\User\ForgetPassword\ResetPasswordCheckCodeRequest;
use App\Models\AllUsers\User;
use App\Services\Profile\ProfileService;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\DB;

class ForgetPasswordController extends Controller
{
    use ResponseTrait;

    private $profileService;

    public function __construct()
    {
        $this->profileService = new ProfileService(User::class);
    }

    public function forgetPasswordSendCode(ForgetPasswordSendCodeRequest $request)
    {
        try {
            $result = $this->profileService->storeAtUpdates(request: $request->validated());
            return $this->jsonResponse(key: $result['key'], msg: $result['msg'], data: $result['data']);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function forgetPasswordCheckCode(ForgetPasswordCheckCodeRequest $request)
    {
        $result = $this->profileService->verifyCode(user: $request->user, request: $request->validated());
        return $this->jsonResponse(key: $result['key'], msg: $result['msg']);
    }

    public function resetPassword(ResetPasswordCheckCodeRequest $request)
    {
        try {
            $data = DB::transaction(function () use ($request) {
                $request->update->delete();
                return $this->profileService->updatePassword($request->only('password', 'user'));
            });

            return $this->jsonResponse(key: $data['key'], msg: $data['msg']);
        } catch (\Exception $e) {
            return $this->jsonResponse(__('apis.something_went_wrong'));
        }
    }
}
