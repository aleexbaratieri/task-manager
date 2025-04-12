<?php

namespace Src\Tasks\Services;

interface TaskServiceInterface
{
    /**
     * Retrieve all tasks associated with a given building.
     *
     * @param  string                                                           $buildingId The building ID.
     * @return \Illuminate\Database\Eloquent\Collection<\Src\Tasks\Models\Task>
     */
    public function getTasksFromBuilding(string $buildingId);

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
    public function getTaskFromBuilding(string $buildingId, string $taskId);

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
    public function createTaskOnBuilding(string $buildingId, array $data);

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
    public function updateTaskOnBuilding(string $buildingId, string $taskId, array $data);

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
    public function deleteTaskFromBuilding(string $buildingId, string $taskId);

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
    public function startTask(string $buildingId, string $taskId);

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
    public function finishTask(string $buildingId, string $taskId);

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
    public function rejectTask(string $buildingId, string $taskId);
}
