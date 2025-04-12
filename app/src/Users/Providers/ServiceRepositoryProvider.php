<?php

namespace Src\Users\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Users\Repositories\UserRepository;
use Src\Users\Repositories\UserRepositoryInterface;
use Src\Users\Services\UserService;
use Src\Users\Services\UserServiceInterface;

class ServiceRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            UserServiceInterface::class,
            UserService::class,
        );

        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class,
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
