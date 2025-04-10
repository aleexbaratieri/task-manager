<?php

namespace Src\Buildings\Repositories;

interface BuildingRepositoryInterface
{
    public function getAll();

    public function getById($id);
}
