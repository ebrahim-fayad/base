<?php

namespace App\Providers;

use Exception;
use Illuminate\Support\Str;
use Dedoc\Scramble\Scramble;
use Illuminate\Routing\Route;
use App\Services\Core\BaseService;
use Illuminate\Pagination\Paginator;
use App\Services\Core\SettingService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use App\Models\PublicSettings\SiteSetting;

class AppServiceProvider extends ServiceProvider
{

    protected $settings;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
        $this->app->singleton('base-service', function ($app, $parameters = []) {
            $model = $parameters['model'] ?? null;
            return new BaseService($model);
        });
    }

    public function boot()
    {
        Paginator::useBootstrap();
        Schema::defaultStringLength(191);
        $folders = array_diff(scandir(database_path() . '/migrations'), ['..', '.']);
        $this->loadMigrationsFrom(
            array_map(function ($folder) {
                return database_path() . '/migrations/' . $folder;
            }, $folders)
        );

        Scramble::configure()
            ->routes(function (Route $route) {
                return Str::startsWith($route->uri, 'api/');
            });

        try {
            $this->settings = Cache::rememberForever('settings', function () {
                return SettingService::appInformations(SiteSetting::pluck('value', 'key'));
            });
        } catch (Exception $e) {
            echo ('app service provider exception :::::::::: ' . $e->getMessage());
        }

        view()->composer('admin.*', function ($view) {
            $view->with([
                'settings' => $this->settings,
            ]);
        });

        // -------------- lang ---------------- \\
        app()->singleton('lang', function () {
            if (session()->has('lang')) {
                return session('lang');
            } else {
                return 'ar';
            }
        });
        // -------------- lang ---------------- \\

        Model::preventLazyLoading(!app()->isProduction());
    }
}
