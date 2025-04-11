<?php

namespace Src\Buildings\Http\Controllers;

use App\Http\Controllers\Controller;
use Src\Buildings\Http\Resources\BuildingResource;
use Src\Buildings\Services\BuildingServiceInterface;

class BuildingController extends Controller
{
    public function __construct(private readonly BuildingServiceInterface $service) {}

    /**
     * List all existing of the resource.
     *
     * @return \Src\Buildings\Http\Resources\BuildingResource
     */
    public function index()
    {
        return BuildingResource::collection($this->service->getAll());
    }

    /**
     * Show the specified resource.
     *
     * @param  string                                         $id The ID of the building.
     * @return \Src\Buildings\Http\Resources\BuildingResource
     */
    public function show(string $id)
    {
        return BuildingResource::make($this->service->getById($id));
    }
}
