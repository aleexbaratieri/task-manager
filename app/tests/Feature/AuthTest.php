<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected string $token;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();

        $this->token = JWTAuth::attempt(['email' => 'admin@admin.com', 'password' => 'secret']);
    }

    public function test_the_user_can_be_authenticated(): void
    {
        $response = $this->post('/api/login', [
            'email' => 'admin@admin.com',
            'password' => 'secret',
        ]);

        $response->assertJsonStructure([
            'token',
            'token_type',
            'expires_at',
            'user' => [
                'id',
                'name',
                'email',
            ]
        ]);

        $response->assertStatus(200);
    }

    public function test_the_user_could_not_be_authenticated(): void
    {
        $response = $this->post('/api/login', [
            'email' => 'admin@admin.com',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(401);
    }

    public function test_the_user_can_be_logged_out(): void
    {
        $response = $this->post('/api/login', [
            'email' => 'admin@admin.com',
            'password' => 'secret',
        ]);

        $token = $response->json('token');

        $response = $this->withToken($token)->post('/api/logout');

        $response->assertStatus(202);
    }

    public function test_the_user_can_be_refreshed(): void
    {
        $response = $this->post('/api/login', [
            'email' => 'admin@admin.com',
            'password' => 'secret',
        ]);

        $token = $response->json('token');

        $response = $this->withToken($token)->post('/api/refresh');

        $response->assertJsonStructure([
            'token',
            'token_type',
            'expires_at',
            'user' => [
                'id',
                'name',
                'email',
            ]
        ]);

        $response->assertStatus(200);
    }

    public function test_the_user_can_be_retrieved(): void
    {
        $response = $this->withToken($this->token)->get('api/me');

        $response->assertJsonStructure([
            'id',
            'name',
            'email',
        ]);

        $response->assertStatus(200);
    }
}
