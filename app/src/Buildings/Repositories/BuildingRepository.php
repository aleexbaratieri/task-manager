<?php

namespace Src\Buildings\Repositories;

use Src\Buildings\Models\Building;

class BuildingRepository implements BuildingRepositoryInterface
{
    public function __construct(private readonly Building $resource) {}

    /**
     * Retrieve all existing buildings.
     *
     * @return \Illuminate\Database\Eloquent\Collection<\Src\Buildings\Models\Building>
     */
    public function getAll()
    {
        return $this->resource::all();
    }

    /**
     * Retrieve a building by its ID.
     *
     * @param string $id The ID of the building to retrieve.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the building is not found.
     *
     * @return \Src\Buildings\Models\Building The building with the specified ID.
     */
    public function getById($id)
    {
        return $this->resource->where('id', $id)->firstOrFail();
    }
}
