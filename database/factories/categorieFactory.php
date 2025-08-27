<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategorieFactory extends Factory
{
    public function definition(): array
    {
        $vTuberCategories = [
            'Hololive', 'VShojo', 'Indépendants', 'Nijisanji', 
            'Musicaux', 'Gaming', 'ASMR', 'Chat', 'Collab', 
            'News', 'Reviews', 'Fan Arts', 'Cosplay'
        ];

        return [
            'date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'nom' => $this->faker->randomElement($vTuberCategories),
            'ID_carte' => \App\Models\Carte::factory(),
        ];
    }
}