<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MentionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'contenu' => $this->faker->sentence(),
        ];
    }
}