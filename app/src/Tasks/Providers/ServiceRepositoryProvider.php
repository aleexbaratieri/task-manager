<?php

namespace Src\Tasks\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Tasks\Repositories\TaskRepository;
use Src\Tasks\Repositories\TaskRepositoryInterface;
use Src\Tasks\Services\TaskService;
use Src\Tasks\Services\TaskServiceInterface;

class ServiceRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            TaskServiceInterface::class,
            TaskService::class,
        );

        $this->app->bind(
            TaskRepositoryInterface::class,
            TaskRepository::class,
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
