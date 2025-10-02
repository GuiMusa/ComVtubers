<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Créer ou mettre à jour l'utilisateur de test
        User::updateOrCreate(
            ['email' => 'test@example.com'], // Condition de recherche
            [
                'name' => 'Test User',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
            ]
        );

        // Appeler les autres seeders
        $this->call([
            testSeeder::class,
        ]);
    }
}
