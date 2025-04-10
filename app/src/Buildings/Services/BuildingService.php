<?php

namespace Src\Buildings\Services;

use Src\Buildings\Repositories\BuildingRepositoryInterface;

class BuildingService implements BuildingServiceInterface
{
    public function __construct(private readonly BuildingRepositoryInterface $repo) {}

    public function getAll()
    {
        return $this->repo->getAll();
    }

    public function getById(string $id)
    {
        return $this->repo->getById($id);
    }
}
