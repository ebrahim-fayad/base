<?php

namespace App\Http\Controllers\Api\User\Auth;

use Illuminate\Http\Request;
use App\Models\AllUsers\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use App\Services\Auth\AuthService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\AllUsers\ClientService;
use App\Http\Resources\Api\User\UserResource;
use App\Http\Requests\Api\User\Auth\LoginRequest;
use App\Http\Requests\Api\User\Auth\ActivateRequest;
use App\Http\Requests\Api\User\Auth\RegisterRequest;
use App\Http\Requests\Api\User\Auth\ResendCodeRequest;
use App\Http\Requests\Api\User\Auth\CompleteDataRequest;

class AuthController extends Controller
{

    use ResponseTrait;


    private $authService, $userService;

    public function __construct()
    {
        $this->authService = new AuthService(User::class);
        $this->userService = new ClientService();
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $data = $this->authService->login($request->validated()['user']);
            return $this->jsonResponse(
                msg: $data['msg'],
                data: UserResource::make($data['data']['user'])->setToken($data['data']['token']),
                key: $data['key']
            );
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            $data = $this->authService->logout(request: $request);
            return $this->jsonResponse(msg: $data['msg']);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function deleteAccount(Request $request): JsonResponse
    {
        try {
            return DB::transaction(function () use ($request) {
                $data = $this->authService->deleteAccount(request: $request);
                return $this->jsonResponse(msg: $data['msg']);
            });
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function register(RegisterRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $user = isset($request->validated()['user']) ? $request->validated()['user'] : $this->authService->create(data: $request->validated());
                $data = $this->authService->sendVerificationCodeToPhone(user: $user);
                return $this->jsonResponse(msg: $data['msg'], data: $data['data']);
            });
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function activate(ActivateRequest $request): JsonResponse
    {
        try {
            return DB::transaction(function () use ($request) {
                $data = $this->authService->activate($request->validated());
                return $this->jsonResponse(msg: $data['msg'], data: UserResource::make($data['data']['user']));
            });
        } catch (\Exception $e) {
            return $this->jsonResponse(msg: $e->getMessage(), code: $e->getCode(), error: true, errors: ['file' => $e->getFile(), 'line' => $e->getLine()]);
        }
    }



    public function resendCode(ResendCodeRequest $request): JsonResponse
    {
        $this->authService->resendCode($request->validated());

        return $this->jsonResponse(msg: __('auth.code_re_send'));
    }

    public function completeData(CompleteDataRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            return DB::transaction(function () use ($data) {
                $this->authService->update(id: $data['id'], data: $data);
                $token = $data['user']->login();
                return $this->jsonResponse(data: UserResource::make($data['user']->refresh())->setToken($token));
            });
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
