<?php

namespace Src\Tasks\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Tasks\Models\Task;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Src\Tasks\Models\Model>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(4),
            'description' => fake()->sentence(10),
        ];
    }
}
