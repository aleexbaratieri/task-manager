<?php

namespace Src\Comments\Observers;

use Src\Comments\Models\Comment;

class CommentObserver
{
    /**
     * Handle the Comment "created" event.
     *
     * @param \Src\Tasks\Models\Comment $task
     */
    public function creating(Comment $comment): void
    {
        $comment->author_id = \Src\Users\Models\User::first()->id;
    }
}
