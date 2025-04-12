<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class BuildingsTest extends TestCase
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
     * A basic feature test example.
     */
    public function test_the_buildings_can_be_retrieved(): void
    {
        $response = $this->withToken($this->token)->get('/api/buildings');

        $response->assertJsonStructure([
            '*' => [
                'id',
                'name',
                'description',
                'address',
                'created_at',
                'updated_at',
            ]
        ]);

        $response->assertJsonCount(10);

        $response->assertStatus(200);
    }

    public function test_the_building_can_be_retrieved_by_id(): void
    {
        $building = \Src\Buildings\Models\Building::first();

        $response = $this->withToken($this->token)->get("/api/buildings/{$building->id}");

        $response->assertJsonStructure([
            'id',
            'name',
            'description',
            'address',
            'created_at',
            'updated_at',
        ]);

        $response->assertStatus(200);
    }

    public function test_the_building_could_not_be_retrieved_by_id(): void
    {
        $response = $this->withToken($this->token)->get('/api/buildings/0');

        $response->assertStatus(404);
    }
}
