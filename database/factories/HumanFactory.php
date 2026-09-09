<?php

namespace Database\Factories;

use App\Models\Human;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Human>
 */
class HumanFactory extends Factory
{
    protected $model = Human::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'aura' => fake()->numberBetween(0, 1000),
            'hierarchy' => fake()->randomElement(['común', 'moderado', 'legendario']),
        ];
    }
}
