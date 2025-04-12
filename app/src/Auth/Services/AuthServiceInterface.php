<?php

namespace Src\Auth\Services;

use Illuminate\Contracts\Auth\Authenticatable;

interface AuthServiceInterface
{
    /**
     * Attempt to authenticate a user and return a JWT token.
     *
     * @throws UnauthorizedException
     */
    public function login(array $credentials): array;

    /**
     * Invalidate the current JWT token, effectively logging the user out.
     *
     * @throws \Tymon\JWTAuth\Exceptions\JWTException
     */
    public function logout(): void;

    /**
     * Refresh a token.
     *
     * @return array The new token's details with the user.
     */
    public function refresh(): array;

    /**
     * Get the authenticated user.
     */
    public function me(): ?Authenticatable;
}
