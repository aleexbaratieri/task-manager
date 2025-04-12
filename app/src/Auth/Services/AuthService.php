<?php

namespace Src\Auth\Services;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;
use Src\Users\Services\UserServiceInterface;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService implements AuthServiceInterface
{
    public function __construct(private readonly UserServiceInterface $userService) {}

    public function register(array $data)
    {
        return $this->userService->createUser($data);
    }

    /**
     * Attempt to authenticate a user and return a JWT token.
     *
     * @throws UnauthorizedException
     */
    public function login(array $credentials): array
    {
        try {

            if (! $token = JWTAuth::attempt($credentials)) {
                throw new UnauthorizedException('Invalid credentials');
            }

            return [
                'token' => $token,
                'token_type' => 'bearer',
                'expires_at' => Carbon::now()->addMinutes(JWTAuth::factory()->getTTL()),
                'user' => Auth::user(),
            ];

        } catch (JWTException $e) {
            throw $e;
        }
    }

    /**
     * Invalidate the current JWT token, effectively logging the user out.
     *
     * @throws \Tymon\JWTAuth\Exceptions\JWTException
     */
    public function logout(): void
    {
        JWTAuth::invalidate(JWTAuth::getToken());
    }

    /**
     * Refresh a token.
     *
     * @return array The new token's details with the user.
     */
    public function refresh(): array
    {
        $token = JWTAuth::refresh(JWTAuth::getToken());

        return [
            'token' => $token,
            'token_type' => 'bearer',
            'expires_at' => Carbon::now()->addMinutes(JWTAuth::factory()->getTTL()),
            'user' => Auth::user(),
        ];
    }

    /**
     * Get the authenticated user.
     */
    public function me(): ?Authenticatable
    {
        return Auth::user();
    }
}
