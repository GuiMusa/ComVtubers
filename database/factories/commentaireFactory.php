<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CommentaireFactory extends Factory
{
    public function definition(): array
    {
        $vTuberComments = [
            'Super stream hier !',
            'J\'adore ce vtuber !',
            'Quelqu\'un a vu sa dernière vidéo ?',
            'Quelle collaboration incroyable !',
            'Le design de son avatar est magnifique',
            'Qui d\'autre est hype pour le prochain event ?',
            'Ses chansons sont tellement underrated',
            'Best vtuber sans aucune hésitation',
            'Quel backstory intéressante !',
            'Quel est votre moment préféré ?'
        ];

        return [
            'date' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'contenu' => $this->faker->randomElement($vTuberComments) . ' ' . $this->faker->sentence(),
            'image' => $this->faker->optional(0.3)->imageUrl(300, 200, 'anime', true),
            'ID_utilisateur' => \App\Models\Utilisateur::factory(),
            'ID_mention' => $this->faker->optional(0.2)->randomElement(\App\Models\Mention::pluck('ID')->toArray()),
        ];
    }
}