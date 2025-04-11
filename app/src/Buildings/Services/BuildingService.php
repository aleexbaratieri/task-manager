<?php

namespace Src\Buildings\Services;

use Src\Buildings\Repositories\BuildingRepositoryInterface;
use Src\Buildings\Filters\LoadRelations;

class BuildingService implements BuildingServiceInterface
{
    protected array $relations = [];

    public function __construct(private readonly BuildingRepositoryInterface $repo)
    {
        $this->relations = LoadRelations::handle();
    }

    /**
     * Retrieve all existing buildings.
     *
     * @return \Illuminate\Database\Eloquent\Collection<\Src\Buildings\Models\Building>
     */
    public function getAll()
    {
        return $this->repo->getAll();
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
    public function getById(string $id)
    {
        return $this->repo->getById($id, $this->relations);
    }
}
