<?php

namespace Src\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Src\Auth\Http\Requests\LoginRequest;
use Src\Auth\Http\Requests\RegisterRequest;
use Src\Auth\Http\Resources\TokenResource;
use Src\Auth\Services\AuthServiceInterface;
use Src\Users\Http\Resources\UserResource;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct(private readonly AuthServiceInterface $service) {}

    public function register(RegisterRequest $request)
    {
        return UserResource::make($this->service->register($request->validated()));
    }

    /**
     * Authenticate a user and return a token.
     *
     * @return TokenResource
     */
    public function login(LoginRequest $request)
    {
        return TokenResource::make($this->service->login($request->validated()));
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        $this->service->logout();

        return response()->json([], Response::HTTP_ACCEPTED);
    }

    /**
     * Refresh the current authentication token and return a new token resource.
     *
     * @return TokenResource
     */
    public function refresh()
    {
        return TokenResource::make($this->service->refresh());
    }

    /**
     * Get the authenticated user.
     *
     * @return \Src\Users\Http\Resources\UserResource
     */
    public function me()
    {
        return UserResource::make($this->service->me());
    }
}
