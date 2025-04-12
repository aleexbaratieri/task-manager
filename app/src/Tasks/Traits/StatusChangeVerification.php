<?php

namespace Src\Tasks\Traits;

use Src\Tasks\Constants\TaskStatus;
use Src\Tasks\Models\Task;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Response;

trait StatusChangeVerification
{
    /**
     * Check if the user is the owner of the task.
     *
     *
     * @throws BadRequestException
     */
    protected function checkIfYouAreTheOwner(Task $task): void
    {
        if ($task->owner_id !== auth()->user()->id) {
            throw new BadRequestException('You are not the owner of this task.', Response::HTTP_FORBIDDEN);
        }
    }

    /**
     * Check if the current status of the task is equal to the status that needs to be changed to.
     *
     * @param string     $currentStatus The current status of the task.
     * @param TaskStatus $needTobe      The status that needs to be changed to.
     *
     * @throws BadRequestException
     */
    protected function checkIfTaskStatusCanBeChanged(string $currentStatus, TaskStatus $needTobe): void
    {
        if ($currentStatus !== $needTobe) {
            throw new BadRequestException('This task status cannot be changed.', Response::HTTP_FORBIDDEN);
        }
    }
}
