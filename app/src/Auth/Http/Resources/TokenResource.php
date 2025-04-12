<?php

namespace Src\Auth\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Src\Users\Http\Resources\UserResource;

class TokenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'token' => $this['token'],
            'token_type' => $this['token_type'],
            'expires_at' => $this['expires_at'],
            'user' => UserResource::make($this['user']),
        ];
    }
}
