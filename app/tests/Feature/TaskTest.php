<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Src\Buildings\Models\Building;
use Src\Tasks\Factories\TaskFactory;
use Src\Users\Factories\UserFactory;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class TaskTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected string $token;

    protected Building $building;

    protected string $baseUrl;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();

        $this->token = JWTAuth::attempt(['email' => 'admin@admin.com', 'password' => 'secret']);

        $this->building = Building::first();

        $this->baseUrl = 'api/buildings/'.$this->building->id.'/tasks';
    }

    public function test_the_tasks_can_be_retrieved(): void
    {
        $user = UserFactory::new()->create();

        TaskFactory::new()->count(5)->create([
            'building_id' => $this->building->id,
            'owner_id' => $user->id,
        ]);

        $response = $this->withToken($this->token)->get($this->baseUrl);

        $response->assertJsonStructure([
            '*' => [
                'id',
                'name',
                'description',
                'status',
            ],
        ]);

        $response->assertJsonCount(5);

        $response->assertStatus(200);
    }

    public function test_the_task_can_be_retrieved_by_id(): void
    {
        $user = UserFactory::new()->create();

        $task = TaskFactory::new()->create([
            'building_id' => $this->building->id,
            'owner_id' => $user->id,
        ]);

        $response = $this->withToken($this->token)->get($this->baseUrl.'/'.$task->id);

        $response->assertJsonStructure([
            'id',
            'name',
            'description',
            'status',
        ]);

        $response->assertStatus(200);
    }

    public function test_the_task_can_be_retrieved_by_id_with_relations_filters(): void
    {
        $user = UserFactory::new()->create();

        $task = TaskFactory::new()->create([
            'building_id' => $this->building->id,
            'owner_id' => $user->id,
        ]);

        $queryParams = [
            'owners' => true,
            'building' => true,
            'authors' => true,
            'comments' => true,
        ];

        $response = $this->withToken($this->token)->get($this->baseUrl.'/'.$task->id.'?'.http_build_query($queryParams));

        $response->assertJsonStructure([
            'id',
            'name',
            'description',
            'owner',
            'author',
            'status',
            'created_at',
            'updated_at',
            'building',
            'comments',
        ]);

        $response->assertStatus(200);
    }

    public function test_the_task_could_not_be_retrieved_by_id(): void
    {
        $response = $this->withToken($this->token)->get($this->baseUrl.'/0');

        $response->assertStatus(404);
    }

    public function test_the_task_can_be_created(): void
    {
        $user = UserFactory::new()->create();

        $response = $this->withToken($this->token)->post($this->baseUrl, [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'owner_id' => $user->id,
        ]);

        $response->assertJsonStructure([
            'id',
            'name',
            'description',
            'status',
            'created_at',
            'updated_at',
        ]);

        $response->assertStatus(201);
    }

    public function test_the_task_can_be_updated(): void
    {
        $user = UserFactory::new()->create();

        $task = TaskFactory::new()->create([
            'building_id' => $this->building->id,
            'owner_id' => $user->id,
        ]);

        $response = $this->withToken($this->token)->put($this->baseUrl.'/'.$task->id, [
            'name' => $this->faker->sentence(7),
            'description' => $this->faker->sentence(12),
            'owner_id' => $user->id,
        ]);

        $response->assertJsonStructure([
            'id',
            'name',
            'description',
            'status',
            'created_at',
            'updated_at',
        ]);

        $response->assertStatus(200);
    }

    public function test_the_task_can_be_deleted(): void
    {
        $user = UserFactory::new()->create();

        $task = TaskFactory::new()->create([
            'building_id' => $this->building->id,
            'owner_id' => $user->id,
        ]);

        $response = $this->withToken($this->token)->delete($this->baseUrl.'/'.$task->id);

        $response->assertStatus(204);
    }

    public function test_the_task_could_not_be_deleted(): void
    {
        $response = $this->withToken($this->token)->delete($this->baseUrl.'/0');

        $response->assertStatus(404);
    }

    public function test_the_task_could_not_be_updated(): void
    {
        $response = $this->withToken($this->token)->put($this->baseUrl.'/0', [
            'name' => $this->faker->sentence(7),
            'description' => $this->faker->sentence(12),
            'owner_id' => $this->faker->randomNumber(),
        ]);

        $response->assertJsonStructure([
            'message',
            'errors' => [
                'owner_id',
            ],
        ]);

        $response->assertStatus(422);
    }

    public function test_the_task_could_not_be_created(): void
    {
        $response = $this->withToken($this->token)->post($this->baseUrl, [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'owner_id' => $this->faker->randomNumber(),
        ]);

        $response->assertJsonStructure([
            'message',
            'errors' => [
                'owner_id',
            ],
        ]);

        $response->assertStatus(422);
    }

    public function test_the_task_could_not_be_created_without_body(): void
    {
        $response = $this->withToken($this->token)->post($this->baseUrl, []);

        $response->assertJsonStructure([
            'message',
            'errors' => [
                'name',
                'owner_id',
            ],
        ]);

        $response->assertStatus(422);
    }

    public function test_the_task_can_be_changed_status_to_in_progress(): void
    {
        $user = UserFactory::new()->create([
            'password' => bcrypt('secret'),
        ]);

        $task = TaskFactory::new()->create([
            'building_id' => $this->building->id,
            'owner_id' => $user->id,
        ]);

        $token = JWTAuth::attempt(['email' => $user->email, 'password' => 'secret']);

        $response = $this->withToken($token)->post($this->baseUrl.'/'.$task->id.'/start');

        $response->assertJsonStructure([
            'id',
            'name',
            'description',
            'status',
            'created_at',
            'updated_at',
        ]);

        $response->assertStatus(200);
    }

    public function test_the_task_can_be_changed_status_to_reject(): void
    {
        $user = UserFactory::new()->create([
            'password' => bcrypt('secret'),
        ]);

        $task = TaskFactory::new()->create([
            'building_id' => $this->building->id,
            'owner_id' => $user->id,
        ]);

        $token = JWTAuth::attempt(['email' => $user->email, 'password' => 'secret']);

        $response = $this->withToken($token)->post($this->baseUrl.'/'.$task->id.'/reject');

        $response->assertJsonStructure([
            'id',
            'name',
            'description',
            'status',
            'created_at',
            'updated_at',
        ]);

        $response->assertStatus(200);
    }

    public function test_the_task_can_be_changed_status_to_completed(): void
    {
        $user = UserFactory::new()->create([
            'password' => bcrypt('secret'),
        ]);

        $task = TaskFactory::new()->create([
            'building_id' => $this->building->id,
            'owner_id' => $user->id,
        ]);

        $token = JWTAuth::attempt(['email' => $user->email, 'password' => 'secret']);

        /**
         * The taks need to be started first
         */
        $response = $this->withToken($token)->post($this->baseUrl.'/'.$task->id.'/start');

        $response = $this->withToken($token)->post($this->baseUrl.'/'.$task->id.'/finish');

        $response->assertJsonStructure([
            'id',
            'name',
            'description',
            'status',
            'created_at',
            'updated_at',
        ]);

        $response->assertStatus(200);
    }
}
