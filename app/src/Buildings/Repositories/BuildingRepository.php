<?php

namespace Src\Buildings\Repositories;

use Src\Buildings\Models\Building;

class BuildingRepository implements BuildingRepositoryInterface
{
    public function __construct(private readonly Building $resource) {}

    public function getAll()
    {
        return $this->resource::all();
    }

    public function getById($id)
    {
        return $this->resource->where('id', $id)->firstOrFail();
    }
}
