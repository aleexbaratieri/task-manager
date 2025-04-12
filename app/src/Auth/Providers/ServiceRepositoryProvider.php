<?php

namespace Src\Auth\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Auth\Services\AuthService;
use Src\Auth\Services\AuthServiceInterface;

class ServiceRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            AuthServiceInterface::class,
            AuthService::class,
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
