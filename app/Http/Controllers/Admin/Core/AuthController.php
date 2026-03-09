<?php

namespace App\Http\Controllers\Admin\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\LoginRequest;
use App\Models\AllUsers\Admin;
use App\Models\PublicSettings\SiteSetting;
use App\Services\Core\SettingService;
use App\Traits\AdminFirstRouteTrait;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    use AdminFirstRouteTrait;

    public function setLanguage(string $lang)
    {
        $lang = in_array($lang, ['ar', 'en']) ? $lang : 'ar';
        session()->forget('lang');
        session()->put('lang', $lang);

        if (auth()->guard('admin')->check()) {
            $this->updateAdminDeviceLang($lang);
        }

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'lang' => $lang,
                'message' => __('admin.language_changed_successfully'),
            ]);
        }

        return back();
    }

    public function showLoginForm()
    {
        $data = SettingService::appInformations(SiteSetting::pluck('value', 'key'));
        return view('admin.auth.login', compact('data'));
    }

    public function login(LoginRequest $request)
    {
        $remember = (bool) $request->remember;

        $admin = Admin::withTrashed()->where('email', $request->email)->first();

        if (!$admin) {
            return $this->loginErrorResponse('email_not_found');
        }

        if ($admin->trashed()) {
            return $this->loginErrorResponse('account_deleted_by_admin');
        }

        if ($this->attemptLogin($request, $remember)) {
            return $this->loginSuccessResponse($request);
        }

        if ($admin->is_blocked) {
            return response()->json(['status' => 0, 'message' => __('auth.blocked')]);
        }

        return $this->loginErrorResponse('incorrect_password');
    }

    public function throttleKey(): string
    {
        return Str::lower(request('email')) . '|' . request()->ip();
    }

    public function checkTooManyFailedAttempts()
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 10)) {
            return;
        }
        return response()->json(['status' => 0, 'message' => 'IP address banned. Too many login attempts, try after 60 minute']);
    }

    public function logout()
    {
        auth('admin')->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect(route('admin.login'));
    }

    /**
     * Attempt to login admin.
     */
    private function attemptLogin(LoginRequest $request, bool $remember): bool
    {
        return auth()->guard('admin')->attempt([
            'email' => $request->email,
            'password' => $request->password,
            'is_blocked' => 0,
        ], $remember);
    }

    /**
     * Login failure response with rate limiting.
     */
    private function loginErrorResponse(string $errorKey)
    {
        RateLimiter::hit($this->throttleKey(), 3600);
        return response()->json([
            'status' => 0,
            'message' => __('admin.' . $errorKey),
        ]);
    }

    /**
     * Login success logic and response.
     */
    private function loginSuccessResponse(LoginRequest $request)
    {
        RateLimiter::clear($this->throttleKey());
        $lang = session('lang', 'ar');

        if ($request->device_id) {
            $admin = auth('admin')->user();
            $admin->devices()->updateOrCreate(
                ['device_id' => $request->device_id],
                [
                    'device_type' => 'web',
                    'lang' => $lang,
                ]
            );
        }

        session()->put('lang', $lang);
        session()->save();
        $request->session()->regenerate();

        return response()->json([
            'status' => 'login',
            'url' => route($this->getAdminFirstRouteName()),
            'message' => __('admin.login_successfully_logged'),
        ]);
    }

    /**
     * Update admin's devices language.
     */
    private function updateAdminDeviceLang(string $lang): void
    {
        $admin = auth('admin')->user();
        if ($admin) {
            $admin->devices()->update(['lang' => $lang]);
        }
    }
}
