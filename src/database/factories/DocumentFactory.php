<?php

namespace Database\Factories;

use App\Models\Document;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentFactory extends Factory
{
    protected $model = Document::class;

    public function definition()
    {
        return [
            'document_number' => 'DOC-' . $this->faker->unique()->numerify('########'),
            'issue_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'type' => $this->faker->randomElement(['entry', 'exit']),
            'supplier' => $this->faker->optional()->company,
            'recipient' => $this->faker->optional()->company,
            'comments' => $this->faker->optional()->sentence
        ];
    }
}