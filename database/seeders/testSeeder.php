<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class testSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Créer les entités sans dépendances externes
        // On crée 10 utilisateurs, principalement actifs, quelques bannis
        $users = \App\Models\User::factory(10)->create([
            'statue' => fn() => fake()->randomElement(['actif', 'actif', 'actif', 'banni']) 
        ]);

        $listes = \App\Models\Liste::factory(5)->create(); // Réduit pour plus de clarté
        $cartes = \App\Models\Carte::factory(10)->create();

        // 2. Créer les catégories fixes (Les 11 catégories uniques)
        $nomsCategories = [
            'Hololive', 'VShojo', 'Indépendants', 'Nijisanji', 
            'Musicaux', 'Gaming', 'ASMR', 'Chat', 'Collab', 
            'News', 'Reviews'
        ];

        $categories = collect();
        foreach ($nomsCategories as $nom) {
            $categories->push(\App\Models\Categorie::create([
                'nom' => $nom,
                'date' => now(),
                'carte_id' => $cartes->random()->id,
            ]));
        }

        // 3. Créer les articles en utilisant les utilisateurs, listes et catégories créés
        $articles = \App\Models\Article::factory(50)->create([
            'user_id' => fn() => $users->random()->id,
            'liste_id' => fn() => $listes->random()->id,
            'categorie_id' => fn() => $categories->random()->id,
            'statue' => fn() => fake()->randomElement(['publié', 'publié', 'publié', 'brouillon']),
            'favoris' => false, // Par défaut pas en favoris
        ]);

        // 4. Créer les commentaires en utilisant les utilisateurs et articles créés
        $commentaires = \App\Models\Commentaire::factory(100)->recycle($users)->recycle($articles)->create();

        // 5. Créer les mentions en utilisant les commentaires créés
        \App\Models\Mention::factory(30)
            ->recycle($commentaires)
            ->create();

        $this->command->info('✅ testSeeder a terminé avec succès avec des catégories uniques.');
    }
}