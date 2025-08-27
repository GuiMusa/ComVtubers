<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UtilisateurFactory extends Factory
{
    public function definition(): array
    {
        $vTuberFanNames = ['GuraFan', 'CalliopeLover', 'KizunaAIFan', 'VTubeEnthusiast', 
                          'HololiveStan', 'VShojoSupporter', 'AnimeVTuber', 'VirtualDreamer'];

        return [
            'date' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'nom' => $this->faker->name(),
            'pseudo' => $this->faker->userName() . $this->faker->randomElement($vTuberFanNames),
            'photo_de_profil' => $this->faker->imageUrl(200, 200, 'people', true, 'avatar'),
            'mail' => $this->faker->unique()->safeEmail(),
            'mdp' => Hash::make('password123'),
            'statue' => $this->faker->randomElement(['actif', 'inactif', 'banni', 'modérateur']),
            'ID_article' => null, // À définir selon vos relations
        ];
    }
}