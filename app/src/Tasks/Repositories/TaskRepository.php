<?php

namespace Src\Tasks\Repositories;

use Carbon\Carbon;
use Src\Tasks\Constants\TaskStatus;
use Src\Tasks\Models\Task;

class TaskRepository implements TaskRepositoryInterface
{
    /**
     * The task model instance.
     *
     * @var \Src\Tasks\Models\Task the task model
     */
    public function __construct(private readonly Task $resource) {}

    /**
     * Retrieve all tasks associated with a given building.
     *
     * @param  string                                                           $buildingId The building ID.
     * @return \Illuminate\Database\Eloquent\Collection<\Src\Tasks\Models\Task>
     */
    public function getTasksByBuilding(string $buildingId, ?string $assignedTo, ?string $status, ?Carbon $created_start, ?Carbon $created_end)
    {
        $tasks = $this->resource->where('building_id', $buildingId);
        
        if ($assignedTo) {
            $tasks->where('owner_id', $assignedTo);
        }
        
        if ($status) {
            $tasks->where('status', $status);
        }
        
        if ($created_start && $created_end) {

            $tasks->whereBetween('created_at', [$created_start, $created_end]);
        }
        
        return $tasks->get();
    }

    /**
     * Retrieve a specific task by building ID and task ID.
     *
     * @param string $buildingId The ID of the building.
     * @param string $id         The ID of the task.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the task is not found.
     *
     * @return \Src\Tasks\Models\Task
     */
    public function getTaskByBuilding(string $buildingId, string $id, array $relations = [])
    {
        return $this->resource->with($relations)->where('building_id', $buildingId)->where('id', $id)->firstOrFail();
    }

    /**
     * Create a new task associated with a given building.
     *
     * @param  string                 $buildingId The ID of the building.
     * @param  array                  $data       The data for creating the task.
     * @return \Src\Tasks\Models\Task The newly created task.
     */
    public function createTaskOnBuilding(array $data)
    {
        return $this->resource->create($data);
    }

    /**
     * Update a specific task associated with a given building.
     *
     * @param string $buildingId The ID of the building.
     * @param string $id         The ID of the task.
     * @param array  $data       The data for updating the task.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the task is not found.
     *
     * @return \Src\Tasks\Models\Task The updated task.
     */
    public function updateTaskOnBuilding(string $buildingId, string $id, array $data)
    {
        $task = $this->getTaskByBuilding($buildingId, $id);

        if ($task->update($data)) {
            return $task;
        }
    }

    /**
     * Delete a specific task associated with a given building.
     *
     * @param string $buildingId The ID of the building.
     * @param string $id         The ID of the task.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the task is not found.
     *
     * @return bool True if the task was deleted, false if not.
     */
    public function deleteTaskFromBuilding(string $buildingId, string $id)
    {
        return $this->getTaskByBuilding($buildingId, $id)->delete();
    }

    /**
     * Set the status of the task.
     *
     * @param  \Src\Tasks\Models\Task          $task   The task to set the status for.
     * @param  \Src\Tasks\Constants\TaskStatus $status The status to set.
     * @return \Src\Tasks\Models\Task          The task with the updated status.
     */
    public function setStatus(Task $task, TaskStatus $status)
    {
        $task->status = $status;
        $task->save();

        return $task;
    }
}
