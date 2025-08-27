<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ListFactory extends Factory
{
    public function definition(): array
    {
        $listNames = [
            'Mes vtubers préférés',
            'Streams à regarder',
            'Collaborations à ne pas manquer',
            'Vtubers musicaux',
            'Les meilleurs moments',
            'Nouveaux talents',
            'Vtubers gaming',
            'Contenu ASMR'
        ];

        return [
            'date' => $this->faker->dateTimeBetween('-3 months', 'now'),
            'favoris' => $this->faker->boolean(40),
            'ID_article' => \App\Models\Article::factory(),
        ];
    }
}