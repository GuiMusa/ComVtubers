<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Créer ou mettre à jour l'utilisateur de test (Admin)
        User::updateOrCreate(
            ['email' => 'test@example.com'], // Condition de recherche
            [
                'name' => 'TestUser',
                'photo_de_profil' => 'https://i.pravatar.cc/200?u=test@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => 'admin',       // Nouveau champ
                'is_admin' => true,      // Nouveau champ
                'status' => 'actif',     // Remplace 'statue'
            ]
        );

        // Appeler les autres seeders
        $this->call([
            testSeeder::class,
        ]);

        $this->command->info('🌱 Base de données initialisée avec les données de test.');
    }
}