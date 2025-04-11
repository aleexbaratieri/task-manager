<?php

namespace Src\Tasks\Http\Controllers;

use App\Http\Controllers\Controller;
use Src\Tasks\Http\Requests\StoreTaskRequest;
use Src\Tasks\Http\Requests\UpdateTaskRequest;
use Src\Tasks\Http\Resources\TaskResource;
use Src\Tasks\Services\TaskServiceInterface;

class TaskController extends Controller
{
    /**
     * The task controller instance.
     *
     * @var \Src\Tasks\Services\TaskServiceInterface
     */
    public function __construct(private readonly TaskServiceInterface $service) {}

    /**
     * List all existing of the resource.
     *
     * @param  string                                        $buildingId The ID of the building.
     * @return array<\Src\Tasks\Http\Resources\TaskResource>
     */
    public function index(string $buildingId)
    {
        return TaskResource::collection($this->service->getTasksFromBuilding($buildingId));
    }

    /**
     * Show the specified resource.
     *
     * @param  string                                 $buildingId The ID of the building.
     * @param  string                                 $taskId     The ID of the task.
     * @return \Src\Tasks\Http\Resources\TaskResource
     */
    public function show(string $buildingId, string $id)
    {
        return TaskResource::make($this->service->getTaskFromBuilding($buildingId, $id));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  string                                    $buildingId The ID of the building.
     * @param  \Src\Tasks\Http\Requests\StoreTaskRequest $request    The request object.
     * @return \Src\Tasks\Http\Resources\TaskResource
     */
    public function store(string $buildingId, StoreTaskRequest $request)
    {
        return TaskResource::make($this->service->createTaskOnBuilding($buildingId, $request->validated()));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  string                                     $buildingId The ID of the building.
     * @param  \Src\Tasks\Http\Requests\UpdateTaskRequest $request    The request object.
     * @param  string                                     $id         The ID of the task.
     * @return \Src\Tasks\Http\Resources\TaskResource
     */
    public function update(string $buildingId, UpdateTaskRequest $request, string $id)
    {
        return TaskResource::make($this->service->updateTaskOnBuilding($buildingId, $id, $request->validated()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string                                 $buildingId The ID of the building.
     * @param  string                                 $taskId     The ID of the task.
     * @return \Src\Tasks\Http\Resources\TaskResource
     */
    public function destroy(string $buildingId, string $id)
    {
        $task = $this->service->deleteTaskFromBuilding($buildingId, $id);

        if ($task) {
            return response()->noContent();
        }
    }
}
