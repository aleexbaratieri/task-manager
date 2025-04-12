<?php

namespace Src\Users\Http\Controllers;

use App\Http\Controllers\Controller;
use Src\Users\Http\Resources\UserResource;
use Src\Users\Services\UserServiceInterface;

class UserController extends Controller
{
    public function __construct(private readonly UserServiceInterface $service) {}

    public function index()
    {
        return UserResource::collection($this->service->getUsers());
    }

    public function show(string $id)
    {
        return UserResource::make($this->service->getUserById($id));
    }
}
