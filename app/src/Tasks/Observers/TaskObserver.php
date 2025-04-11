<?php

namespace Src\Tasks\Observers;

use Src\Tasks\Constants\TaskStatus;
use Src\Tasks\Models\Task;

class TaskObserver
{
    /**
     * Handle the Task "created" event.
     */
    public function creating(Task $task): void
    {
        $task->author_id = auth()->user()->id;
        $task->status = TaskStatus::OPEN;
    }
}
