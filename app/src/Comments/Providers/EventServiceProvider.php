<?php

namespace Src\Comments\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Comments\Models\Comment;
use Src\Comments\Observers\CommentObserver;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Comment::observe(CommentObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
