<?php

namespace Rondigital\Auth;

use Illuminate\Support\ServiceProvider;

/**
 * Class PackageServiceProvider.
 */
class PackageServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('auth_service', AuthService::class);
        $this->mergeConfigFrom(__DIR__ . './../config/auth-service.php', 'auth-service');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configurePublishing();
    }

    /**
     * Configure publishing for the package.
     *
     * @return void
     */
    protected function configurePublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__ . './../config/auth-service.php' => config_path('auth-service.php')],
                'auth-service');
        }
    }
}