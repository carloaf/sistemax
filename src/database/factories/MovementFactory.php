<?php

namespace Database\Factories;

use App\Models\Movement;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovementFactory extends Factory
{
    protected $model = Movement::class;

    public function definition()
    {
        return [
            'material_id' => \App\Models\Material::factory(),
            'type' => $this->faker->randomElement(['entry', 'exit']),
            'quantity' => $this->faker->numberBetween(1, 20),
            'observation' => $this->faker->sentence,
        ];
    }
}
