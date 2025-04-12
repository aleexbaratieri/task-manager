<?php

namespace Src\Auth\Services;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService implements AuthServiceInterface
{
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

    public function logout(): void
    {
        JWTAuth::invalidate(JWTAuth::getToken());
    }

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

    public function me(): ?Authenticatable
    {
        return Auth::user();
    }
}
