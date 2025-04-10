<?php

namespace Src\Buildings\Services;

interface BuildingServiceInterface
{
    public function getAll();

    public function getById(string $id);
}
