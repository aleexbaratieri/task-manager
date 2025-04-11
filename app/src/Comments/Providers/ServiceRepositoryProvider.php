<?php

namespace Src\Comments\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Comments\Repositories\CommentRepository;
use Src\Comments\Repositories\CommentRepositoryInterface;
use Src\Comments\Services\CommentService;
use Src\Comments\Services\CommentServiceInterface;

class ServiceRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            CommentServiceInterface::class,
            CommentService::class,
        );

        $this->app->bind(
            CommentRepositoryInterface::class,
            CommentRepository::class,
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
