<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    public function definition(): array
    {
        $vTuberTopics = [
            'Nouvelle collaboration entre Hololive et VShojo',
            'Analyse du dernier stream de Gawr Gura',
            'Les meilleurs moments de Mori Calliope cette semaine',
            'Guide des vtubers débutants à suivre',
            'Review du nouvel équipement de streaming de Kizuna AI',
            'Les tendances du vtubing en 2024',
            'Interview exclusive avec un manager de vtuber',
            'Les backstories les plus intéressantes des vtubers',
            'Comment créer son avatar virtuel : guide complet',
            'Les scandales qui ont marqué la communauté vtuber'
        ];

        return [
            'date' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'titre' => $this->faker->randomElement($vTuberTopics),
            'statue' => $this->faker->randomElement(['actif', 'brouillon', 'archivé']),
            'favoris' => $this->faker->boolean(30),
            'ID_message' => null, // À définir selon vos relations
        ];
    }
}