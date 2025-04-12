<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Users\Models\User;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    protected string $token;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();

        $this->token = JWTAuth::attempt(['email' => 'admin@admin.com', 'password' => 'secret']);
    }

    /**
     * A basic test example.
     */
    public function test_the_users_can_be_retrieved(): void
    {
        $response = $this->withToken($this->token)->get('/api/users');

        $response->assertJsonStructure([
            '*' => [
                'id',
                'name',
                'email',
            ]
        ]);

        $response->assertJsonCount(1);

        $response->assertStatus(200);
    }

    public function test_the_user_can_be_retrieved_by_id(): void
    {
        $user = User::first();

        $response = $this->withToken($this->token)->get("/api/users/{$user->id}");

        $response->assertJsonStructure([
            'id',
            'name',
            'email',
        ]);

        $response->assertStatus(200);
    }

    public function test_the_user_could_not_be_retrieved_by_id(): void
    {
        $response = $this->withToken($this->token)->get('/api/users/0');

        $response->assertStatus(404);
    }
}
