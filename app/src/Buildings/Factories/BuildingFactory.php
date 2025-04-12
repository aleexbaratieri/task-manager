<?php

namespace Src\Buildings\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Buildings\Models\Building;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BuildingFactory extends Factory
{
    protected $model = Building::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'description' => fake()->catchPhrase(),
            'address' => fake()->address(),
        ];
    }
}
