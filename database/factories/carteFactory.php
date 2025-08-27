<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CarteFactory extends Factory
{
    public function definition(): array
    {
        $vTubers = ['Kizuna AI', 'Gawr Gura', 'Mori Calliope', 'Takanashi Kiara', 'Ninomae Ina\'nis', 
                   'Hololive EN', 'VShojo', 'Neuro-sama', 'CodeMiko', 'Projekt Melody'];
        
        return [
            'date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'nom' => $this->faker->randomElement($vTubers),
            'information' => $this->faker->paragraph(3),
            'image' => $this->faker->imageUrl(400, 300, 'anime', true, 'vtuber'),
        ];
    }
}