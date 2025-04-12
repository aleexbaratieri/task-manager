<?php

namespace Src\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Src\Auth\Http\Requests\LoginRequest;
use Src\Auth\Http\Resources\TokenResource;
use Src\Auth\Services\AuthServiceInterface;
use Src\Users\Http\Resources\UserResource;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct(private readonly AuthServiceInterface $service) {}

    public function login(LoginRequest $request)
    {
        return TokenResource::make($this->service->login($request->validated()));
    }

    public function logout()
    {
        $this->service->logout();

        return response()->json([], Response::HTTP_ACCEPTED);
    }

    public function refresh()
    {
        return TokenResource::make($this->service->refresh());
    }

    public function me()
    {
        return UserResource::make($this->service->me());
    }
}
