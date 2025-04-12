<?php

namespace Src\Auth\Services;

use Illuminate\Contracts\Auth\Authenticatable;

interface AuthServiceInterface
{
    public function login(array $credentials): array;

    public function logout(): void;

    public function refresh(): array;

    public function me(): ?Authenticatable;
}
