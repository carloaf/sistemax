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
            'code' => 'MAT-' . str_pad($this->faker->unique()->numberBetween(1, 1000), 6, '0', STR_PAD_LEFT),
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence,
            'unit' => $this->faker->randomElement(['UN', 'KG', 'MT', 'CX']),
            'quantity' => $this->faker->numberBetween(100, 1000),
            'average_unit_price' => $this->faker->randomFloat(2, 5, 500)
        ];
    }
}
