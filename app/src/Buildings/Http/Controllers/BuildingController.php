<?php

namespace Src\Buildings\Http\Controllers;

use App\Http\Controllers\Controller;
use Src\Buildings\Services\BuildingServiceInterface;

class BuildingController extends Controller
{
    public function __construct(private readonly BuildingServiceInterface $service) {}

    /**
     * List all existing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->service->getAll();
    }

    /**
     * Show the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        return $this->service->getById($id);
    }
}
