<?php

namespace Src\Buildings\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Buildings\Repositories\BuildingRepository;
use Src\Buildings\Repositories\BuildingRepositoryInterface;
use Src\Buildings\Services\BuildingService;
use Src\Buildings\Services\BuildingServiceInterface;

class ServiceRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            BuildingServiceInterface::class,
            BuildingService::class,
        );

        $this->app->bind(
            BuildingRepositoryInterface::class,
            BuildingRepository::class,
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
