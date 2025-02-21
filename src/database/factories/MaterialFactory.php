<?php

namespace Database\Factories;

use App\Models\Material;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaterialFactory extends Factory
{
    protected $model = Material::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'quantity' => $this->faker->numberBetween(0, 100),
            'minimum_stock' => $this->faker->numberBetween(10, 20),
            'unit_price' => $this->faker->randomFloat(2, 1, 100),
        ];
    }
}
