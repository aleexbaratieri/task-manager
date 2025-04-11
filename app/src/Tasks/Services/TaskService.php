<?php

namespace Src\Tasks\Services;

use Src\Tasks\Filters\LoadRelations;
use Src\Tasks\Repositories\TaskRepositoryInterface;

class TaskService implements TaskServiceInterface
{
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
    public function getTasksFromBuilding(string $buildingId)
    {
        return $this->repo->getTasksByBuilding($buildingId);
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
}
