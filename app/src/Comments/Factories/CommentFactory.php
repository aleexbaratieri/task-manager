<?php

namespace Src\Comments\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Comments\Models\Comment;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CommentFactory extends Factory
{
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'comment' => $this->faker->text(),
        ];
    }
}
