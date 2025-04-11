<?php

namespace Src\Buildings\Repositories;

interface BuildingRepositoryInterface
{
    /**
     * Retrieve all existing buildings.
     *
     * @return \Illuminate\Database\Eloquent\Collection<\Src\Buildings\Models\Building>
     */
    public function getAll();

    /**
     * Retrieve a building by its ID.
     *
     * @param string $id The ID of the building to retrieve.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the building is not found.
     *
     * @return \Src\Buildings\Models\Building The building with the specified ID.
     */
    public function getById($id);
}
