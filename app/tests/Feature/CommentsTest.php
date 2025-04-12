<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Src\Buildings\Models\Building;
use Src\Comments\Factories\CommentFactory;
use Src\Tasks\Factories\TaskFactory;
use Src\Tasks\Models\Task;
use Src\Users\Factories\UserFactory;
use Src\Users\Models\User;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class CommentsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected string $token;

    protected User $owner;

    protected Building $building;

    protected Task $task;

    protected string $baseUrl;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();

        $this->token = JWTAuth::attempt(['email' => 'admin@admin.com', 'password' => 'secret']);

        $this->building = Building::first();

        $this->owner = UserFactory::new()->create([
            'password' => bcrypt('secret'),
        ]);

        $this->task = TaskFactory::new()->create([
            'building_id' => $this->building->id,
            'owner_id' => $this->owner->id,
            'name' => 'Test task',
            'description' => 'Test description',
        ]);

        $this->baseUrl = 'api/buildings/'.$this->building->id.'/tasks/'.$this->task->id.'/comments';
    }

    public function test_the_comment_can_be_created(): void
    {
        $response = $this->withToken($this->token)->post($this->baseUrl, [
            'comment' => $this->faker->text,
        ]);

        $response->assertJsonStructure([
            'id',
            'comment',
            'created_at',
            'updated_at',
        ]);

        $response->assertStatus(201);
    }

    public function test_the_comment_can_be_retrieved(): void
    {
        $comment = CommentFactory::new()->create([
            'task_id' => $this->task->id,
            'building_id' => $this->building->id,
            'author_id' => $this->owner->id,
        ]);

        $response = $this->withToken($this->token)->get($this->baseUrl.'/'.$comment->id);

        $response->assertJsonStructure([
            'id',
            'comment',
            'created_at',
            'updated_at',
        ]);

        $response->assertStatus(200);
    }

    public function test_the_comment_could_not_be_retrieved_by_id(): void
    {
        $response = $this->withToken($this->token)->get($this->baseUrl.'/0');

        $response->assertStatus(404);
    }

    public function test_the_comment_can_be_retrieved_with_relations_filters(): void
    {
        $comment = CommentFactory::new()->create([
            'task_id' => $this->task->id,
            'building_id' => $this->building->id,
            'author_id' => $this->owner->id,
        ]);

        $queryParams = [
            'task' => true,
            'building' => true,
            'authors' => true,
            'owners' => true,
        ];

        $response = $this->withToken($this->token)->get($this->baseUrl.'/'.$comment->id .'?'.http_build_query($queryParams));

        $response->assertJsonStructure([
            'id',
            'comment',
            'task' => [
                'building',
            ],
            'author',
            'created_at',
            'updated_at',
        ]);

        $response->assertStatus(200);
    }

    public function test_the_comments_can_be_retrieved(): void
    {
        CommentFactory::new()->count(10)->create([
            'task_id' => $this->task->id,
            'building_id' => $this->building->id,
            'author_id' => $this->owner->id,
        ]);

        $response = $this->withToken($this->token)->get($this->baseUrl);

        $response->assertJsonStructure([
            '*' => [
                'id',
                'comment',
                'created_at',
                'updated_at',
            ],
        ]);

        $response->assertJsonCount(10);

        $response->assertStatus(200);
    }

    public function test_the_comment_can_be_deleted(): void
    {
        $user = UserFactory::new()->create([
            'password' => bcrypt('secret'),
        ]);

        $token = JWTAuth::attempt(['email' => $user->email, 'password' => 'secret']);
        
        $comment = CommentFactory::new()->create([
            'task_id' => $this->task->id,
            'building_id' => $this->building->id,
            'author_id' => $user->id,
        ]);

        $response = $this->withToken($token)->delete($this->baseUrl.'/'.$comment->id);

        $response->assertStatus(204);
    }

    public function test_the_comment_could_not_be_deleted_by_the_not_author(): void
    {
        $user = UserFactory::new()->create([
            'password' => bcrypt('secret'),
        ]);

        JWTAuth::attempt(['email' => $user->email, 'password' => 'secret']);
        
        $comment = CommentFactory::new()->create([
            'task_id' => $this->task->id,
            'building_id' => $this->building->id,
            'author_id' => $user->id,
        ]);

        JWTAuth::attempt(['email' => 'admin@admin.com', 'password' => 'secret']);

        $response = $this->withToken($this->token)->delete($this->baseUrl.'/'. $comment->id);  

        $response->assertStatus(401);
    }
}
