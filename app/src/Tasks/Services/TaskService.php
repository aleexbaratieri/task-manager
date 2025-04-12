<?php

namespace Src\Tasks\Services;

use Carbon\Carbon;
use Src\Tasks\Constants\TaskStatus;
use Src\Tasks\Filters\LoadRelations;
use Src\Tasks\Filters\QueryParamsFilters;
use Src\Tasks\Repositories\TaskRepositoryInterface;
use Src\Tasks\Traits\StatusChangeVerification;

class TaskService implements TaskServiceInterface
{
    use StatusChangeVerification;

    protected array $relations = [];

    /**
     * The task repository instance.
     *
     * @var \Src\Tasks\Repositories\TaskRepositoryInterface
     */
    public function __construct(private readonly TaskRepositoryInterface $repo)
    {
        $this->relations = LoadRelations::handle();
    }

    /**
     * Retrieve all tasks associated with a given building.
     *
     * @param  string                                                           $buildingId The building ID.
     * @return \Illuminate\Database\Eloquent\Collection<\Src\Tasks\Models\Task>
     */
    public function getTasksFromBuilding(string $buildingId, array $filters = [])
    {
        $assignedTo = QueryParamsFilters::getFilterValue($filters, 'assigned_to');
        $status = QueryParamsFilters::getFilterValue($filters, 'status');
        $created_start = QueryParamsFilters::getFilterValue($filters, 'created_start');
        $created_end = QueryParamsFilters::getFilterValue($filters, 'created_end');

        return $this->repo->getTasksByBuilding($buildingId, $assignedTo, $status, $created_start, $created_end);
    }

    /**
     * Retrieve a specific task associated with a given building.
     *
     * @param string $buildingId The ID of the building.
     * @param string $taskId     The ID of the task.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the task is not found.
     *
     * @return \Src\Tasks\Models\Task The task.
     */
    public function getTaskFromBuilding(string $buildingId, string $taskId)
    {
        return $this->repo->getTaskByBuilding($buildingId, $taskId, $this->relations);
    }

    /**
     * Create a new task associated with a given building.
     *
     * This method merges additional data such as author ID, building ID,
     * and default task status into the provided data array before creating
     * the task.
     *
     * @param  string                 $buildingId The ID of the building where the task is created.
     * @param  array                  $data       The data for creating the task.
     * @return \Src\Tasks\Models\Task The newly created task.
     */
    public function createTaskOnBuilding(string $buildingId, array $data)
    {
        return $this->repo->createTaskOnBuilding(array_merge($data, ['building_id' => $buildingId]));
    }

    /**
     * Update a specific task associated with a given building.
     *
     * @param string $buildingId The ID of the building.
     * @param string $taskId     The ID of the task.
     * @param array  $data       The data for updating the task.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the task is not found.
     *
     * @return \Src\Tasks\Models\Task The updated task.
     */
    public function updateTaskOnBuilding(string $buildingId, string $taskId, array $data)
    {
        return $this->repo->updateTaskOnBuilding($buildingId, $taskId, $data);
    }

    /**
     * Delete a specific task associated with a given building.
     *
     * @param string $buildingId The ID of the building.
     * @param string $taskId     The ID of the task.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the task is not found.
     *
     * @return bool True if the task was deleted, false if not.
     */
    public function deleteTaskFromBuilding(string $buildingId, string $taskId)
    {
        return $this->repo->deleteTaskFromBuilding($buildingId, $taskId);
    }

    /**
     * Mark a specific task as in progress for a given building.
     *
     * @param string $buildingId The ID of the building.
     * @param string $taskId     The ID of the task.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the task is not found.
     * @throws \DomainException                                     If the task is not open.
     *
     * @return \Src\Tasks\Models\Task The updated task.
     */
    public function startTask(string $buildingId, string $taskId)
    {
        $task = $this->repo->getTaskByBuilding($buildingId, $taskId);

        $this->checkIfYouAreTheOwner($task);
        $this->checkIfTaskStatusCanBeChanged($task->status, TaskStatus::OPEN);

        return $this->repo->setStatus($task, TaskStatus::IN_PROGRESS);
    }

    /**
     * Mark a specific task as completed for a given building.
     *
     * @param string $buildingId The ID of the building.
     * @param string $taskId     The ID of the task.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the task is not found.
     * @throws \DomainException                                     If the task is not in progress.
     *
     * @return \Src\Tasks\Models\Task The updated task with completed status.
     */
    public function finishTask(string $buildingId, string $taskId)
    {
        $task = $this->repo->getTaskByBuilding($buildingId, $taskId);

        $this->checkIfYouAreTheOwner($task);
        $this->checkIfTaskStatusCanBeChanged($task->status, TaskStatus::IN_PROGRESS);

        return $this->repo->setStatus($task, TaskStatus::COMPLETED);
    }

    /**
     * Mark a specific task as rejected for a given building.
     *
     * @param string $buildingId The ID of the building.
     * @param string $taskId     The ID of the task.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the task is not found.
     * @throws \DomainException                                     If the task is not open.
     *
     * @return \Src\Tasks\Models\Task The updated task with rejected status.
     */
    public function rejectTask(string $buildingId, string $taskId)
    {
        $task = $this->repo->getTaskByBuilding($buildingId, $taskId);

        $this->checkIfYouAreTheOwner($task);
        $this->checkIfTaskStatusCanBeChanged($task->status, TaskStatus::OPEN);

        return $this->repo->setStatus($task, TaskStatus::REJECTED);
    }
}
