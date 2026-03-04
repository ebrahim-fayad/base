<?php

use Illuminate\Http\Request;
use App\Http\Middleware\WebCors;
use App\Http\Middleware\SiteLang;
use App\Http\Middleware\HtmlMifier;
use App\Http\Middleware\Api\ApiCors;
use App\Http\Middleware\Api\ApiLang;
use App\Http\Middleware\TrimStrings;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\TrustProxies;
use Illuminate\Foundation\Application;
use App\Http\Middleware\EncryptCookies;
use Illuminate\Database\QueryException;
use App\Http\Middleware\Admin\AdminLang;
use App\Http\Middleware\CheckAuthStatus;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Auth\Middleware\Authorize;
use App\Http\Middleware\AdminCheckBlocked;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Auth\AuthenticationException;
use App\Http\Middleware\Admin\AdminMiddleware;
use Illuminate\Auth\Middleware\RequirePassword;
use Illuminate\Http\Middleware\SetCacheHeaders;
use Illuminate\Session\Middleware\StartSession;
use App\Http\Middleware\CheckForMaintenanceMode;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\Admin\IsBlockedMiddleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Laravel\Sanctum\Http\Middleware\CheckAbilities;
use Illuminate\Routing\Middleware\ValidateSignature;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Routing\Middleware\SubstituteBindings;
use App\Http\Middleware\Api\OptionalSanctumMiddleware;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Http\Middleware\Api\CheckAuthUserApproveStatus;
use Laravel\Sanctum\Http\Middleware\CheckForAnyAbility;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Foundation\Http\Middleware\ValidatePostSize;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: [__DIR__ . '/../routes/web.php', __DIR__ . '/../routes/site.php'],
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withSchedule(function (Schedule $schedule) {
        $schedule->command('daily:physical-activity-check')->dailyAt('23:59');
        $schedule->command('daily:macros-reward')->dailyAt('23:59');
    })
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append([
            TrustProxies::class,
            CheckForMaintenanceMode::class,
            ValidatePostSize::class,
            TrimStrings::class,
            ConvertEmptyStringsToNull::class,
        ]);

        $middleware->alias([
            'auth'                      => Authenticate::class,
            'auth.basic'                => AuthenticateWithBasicAuth::class,
            'bindings'                  => SubstituteBindings::class,
            'cache.headers'             => SetCacheHeaders::class,
            'can'                       => Authorize::class,
            'guest'                     => RedirectIfAuthenticated::class,
            'password.confirm'          => RequirePassword::class,
            'signed'                    => ValidateSignature::class,
            'throttle'                  => ThrottleRequests::class,
            'verified'                  => EnsureEmailIsVerified::class,
            'HtmlMinifier'              => HtmlMifier::class,
            'is-active'                 => CheckAuthStatus::class,
            'api_is_blocked'            => \App\Http\Middleware\Api\IsBlockedMiddleware::class,
            'is_blocked'                => IsBlockedMiddleware::class,
            'is-approved'               => CheckAuthUserApproveStatus::class,
            'admin'                     => AdminMiddleware::class,
            // 'check-role'                        => \App\Http\Middleware\Admin\CheckRoleMiddleware::class,
            'admin-lang'                => AdminLang::class,
            'web-cors'                  => WebCors::class,
            'api-lang'                  => ApiLang::class,
            // 'api-cors'                          => \App\Http\Middleware\Api\ApiCors::class,
            'OptionalSanctumMiddleware' => OptionalSanctumMiddleware::class,
            'abilities'                 => CheckAbilities::class,
            'ability'                   => CheckForAnyAbility::class,
            'admin-check-blocked'       => AdminCheckBlocked::class,
        ]);

        $middleware->group('web', [
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            SiteLang::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            ShareErrorsFromSession::class,
            VerifyCsrfToken::class,
            SubstituteBindings::class,
        ]);

        $middleware->group('api', [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:60,1',
            ApiLang::class,
            SubstituteBindings::class,
            ApiCors::class
        ]);

        $middleware->priority([
            Authenticate::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (QueryException $exception, Request $request) {
            if ($request->is('api/*')) {
                return responseJson(
                    msg: $exception->getMessage(),
                    code: ResponseAlias::HTTP_BAD_REQUEST,
                    error: true,
                    errors: ['line' => $exception->getLine(), 'file' => $exception->getFile()]
                );
            }
        });
        $exceptions->render(function (TypeError $exception, Request $request) {
            if ($request->is('api/*')) {
                return responseJson(
                    msg: $exception->getMessage(),
                    code: $exception->status ?? ResponseAlias::HTTP_BAD_REQUEST,
                    error: true,
                    errors: ['line' => $exception->getLine(), 'file' => $exception->getFile()]
                );
            }
        });

        $exceptions->render(function (ErrorException $exception, Request $request) {
            if ($request->is('api/*')) {
                return responseJson(
                    msg: $exception->getMessage(),
                    code: $exception->status ?? ResponseAlias::HTTP_BAD_REQUEST,
                    error: true,
                    errors: ['line' => $exception->getLine(), 'file' => $exception->getFile()]
                );
            }
        });

        $exceptions->render(function (ModelNotFoundException $exception, Request $request) {
            if ($request->is('api/*')) {
                return responseJson(
                    msg: 'Model Not Found' ?? $exception->getMessage(),
                    code: ResponseAlias::HTTP_NOT_FOUND,
                    error: true,
                    errors: ['line' => $exception->getLine(), 'file' => $exception->getFile()]
                );
            }
        });

        $exceptions->render(function (NotFoundHttpException $exception, Request $request) {
            if ($request->is('api/*')) {
                return responseJson(
                    msg: 'Not Found Http' ?? $exception->getMessage(),
                    code: ResponseAlias::HTTP_NOT_FOUND,
                    error: true,
                    errors: ['line' => $exception->getLine(), 'file' => $exception->getFile()]
                );
            }
        });

        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->is('api/*')) {
                return responseJson(
                    msg: trans('auth.unauthenticated'),
                    code: ResponseAlias::HTTP_UNAUTHORIZED,
                    error: true,
                    key: 'unauthenticated'
                );
            }
        });

        $exceptions->render(function (ParseError $exception, Request $request) {
            if ($request->is('api/*')) {
                return responseJson(
                    msg: $exception->getMessage(),
                    code: ResponseAlias::HTTP_INTERNAL_SERVER_ERROR,
                    error: true,
                    errors: ['line' => $exception->getLine(), 'file' => $exception->getFile()]
                );
            }
        });

        $exceptions->render(function (Error $exception, Request $request) {
            if ($request->is('api/*')) {
                return responseJson(
                    msg: $exception->getMessage(),
                    code: ResponseAlias::HTTP_INTERNAL_SERVER_ERROR,
                    error: true,
                    errors: ['line' => $exception->getLine(), 'file' => $exception->getFile()]
                );
            }
        });

        $exceptions->render(function (AccessDeniedHttpException $exception, Request $request) {
            if ($request->is('api/*')) {
                return responseJson(
                    msg: __('apis.have_no_permission'),
                    code: ResponseAlias::HTTP_UNPROCESSABLE_ENTITY,
                    error: true,
                    errors: ['line' => $exception->getLine(), 'file' => $exception->getFile()]
                );
            }
        });

        $exceptions->render(function (Exception $exception, Request $request) {
            if ($request->is('api/*')) {
                return responseJson(
                    msg: $exception->getMessage(),
                    code: $exception->getCode() != 0 ? $exception->getCode() : ResponseAlias::HTTP_INTERNAL_SERVER_ERROR,
                    error: true,
                    errors: ['line' => $exception->getLine(), 'file' => $exception->getFile()]
                );
            }
        });

        $exceptions->render(function (Throwable $exception, Request $request) {
            if ($request->is('api/*')) {
                return responseJson(
                    msg: $exception->getMessage(),
                    code: ResponseAlias::HTTP_UNPROCESSABLE_ENTITY,
                    error: true,
                    errors: ['line' => $exception->getLine(), 'file' => $exception->getFile()]
                );
            }
        });
    })->create();
