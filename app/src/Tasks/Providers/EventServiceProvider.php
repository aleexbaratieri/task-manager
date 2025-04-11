<?php

namespace Src\Tasks\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Tasks\Models\Task;
use Src\Tasks\Observers\TaskObserver;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Task::observe(TaskObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
