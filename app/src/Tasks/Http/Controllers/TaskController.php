<?php

namespace Src\Tasks\Http\Controllers;

use App\Http\Controllers\Controller;
use Src\Tasks\Http\Requests\StoreTaskRequest;
use Src\Tasks\Http\Requests\UpdateTaskRequest;
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
     * @param  string                    $buildingId The ID of the building.
     * @return \Illuminate\Http\Response
     */
    public function index(string $buildingId)
    {
        return $this->service->getTasksFromBuilding($buildingId);
    }

    /**
     * Show the specified resource.
     *
     * @param  string                    $buildingId The ID of the building.
     * @param  string                    $taskId     The ID of the task.
     * @return \Illuminate\Http\Response
     */
    public function show(string $buildingId, string $id)
    {
        return $this->service->getTaskFromBuilding($buildingId, $id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  string                                    $buildingId The ID of the building.
     * @param  \Src\Tasks\Http\Requests\StoreTaskRequest $request    The request object.
     * @return \Illuminate\Http\Response
     */
    public function store(string $buildingId, StoreTaskRequest $request)
    {
        return $this->service->createTaskOnBuilding($buildingId, $request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  string                                     $buildingId The ID of the building.
     * @param  \Src\Tasks\Http\Requests\UpdateTaskRequest $request    The request object.
     * @param  string                                     $id         The ID of the task.
     * @return \Illuminate\Http\Response
     */
    public function update(string $buildingId, UpdateTaskRequest $request, string $id)
    {
        return $this->service->updateTaskOnBuilding($buildingId, $id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string                    $buildingId The ID of the building.
     * @param  string                    $taskId     The ID of the task.
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $buildingId, string $id)
    {
        $task = $this->service->deleteTaskFromBuilding($buildingId, $id);

        if ($task) {
            return response()->noContent();
        }
    }
}
