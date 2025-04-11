<?php

namespace Src\Tasks\Repositories;

interface TaskRepositoryInterface
{
    /**
     * Retrieve all tasks associated with a given building.
     *
     * @param  string                                                           $buildingId The building ID.
     * @return \Illuminate\Database\Eloquent\Collection<\Src\Tasks\Models\Task>
     */
    public function getTasksByBuilding(string $buildingId);

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
    public function getTaskByBuilding(string $buildingId, string $id);

    /**
     * Create a new task associated with a given building.
     *
     * @param  string                 $buildingId The ID of the building.
     * @param  array                  $data       The data for creating the task.
     * @return \Src\Tasks\Models\Task The newly created task.
     */
    public function createTaskOnBuilding(array $data);

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
    public function updateTaskOnBuilding(string $buildingId, string $id, array $data);

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
    public function deleteTaskFromBuilding(string $buildingId, string $id);
}
