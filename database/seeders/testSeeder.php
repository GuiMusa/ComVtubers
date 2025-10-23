<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class testSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Créer les entités sans dépendances externes
        $users = \App\Models\User::factory(5)->create(); // Changé de 50 à 5 et utilise User
        $listes = \App\Models\Liste::factory(30)->create();
        $cartes = \App\Models\Carte::factory(20)->create();

        // 2. Créer les articles en utilisant les utilisateurs et listes créés
        $articles = \App\Models\Article::factory(100)->recycle($users)->recycle($listes)->create();

        // 3. Créer les commentaires en utilisant les utilisateurs et articles créés
        $commentaires = \App\Models\Commentaire::factory(200)->recycle($users)->recycle($articles)->create();

        // 4. Créer les catégories en utilisant les cartes et articles créés
        //    Cela simule une relation plusieurs-à-plusieurs
        \App\Models\Categorie::factory(40)
            ->recycle($cartes)
            ->recycle($articles)
            ->create();

        // 5. Créer les mentions en utilisant les commentaires créés
        \App\Models\Mention::factory(50)
            ->recycle($commentaires)
            ->create();

        $this->command->info('✅ testSeeder a terminé avec succès.');
    }
}