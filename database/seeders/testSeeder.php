<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class testSeeder extends Seeder
{
    /**
     * Exécute le remplissage de la base de données.
     */
    public function run(): void
    {
        // 1. CRÉATION DES UTILISATEURS
        // On crée 10 utilisateurs aléatoires via la Factory.
        // On définit aléatoirement leur statut : principalement 'actif', avec quelques 'banni' pour tester les filtres.
        $users = \App\Models\User::factory(10)->create([
            'statue' => fn() => fake()->randomElement(['actif', 'actif', 'actif', 'banni']) 
        ]);

        // 2. CRÉATION DES DÉPENDANCES (Cartes et Listes)
        // Requis par la structure de la base de données pour lier les futurs articles.
        $listes = \App\Models\Liste::factory(5)->create();
        $cartes = \App\Models\Carte::factory(10)->create();

        // 3. CRÉATION DES CATÉGORIES (Fixes)
        // On crée exactement les 11 catégories thématiques du forum.
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
                'carte_id' => $cartes->random()->id, // On lie chaque catégorie à une carte au hasard
            ]));
        }

        // 4. CRÉATION DES ARTICLES
        // On crée 50 articles de test en les liant aux utilisateurs, listes et catégories créés plus haut.
        $articles = \App\Models\Article::factory(50)->create([
            'user_id' => fn() => $users->random()->id,
            'liste_id' => fn() => $listes->random()->id,
            'categorie_id' => fn() => $categories->random()->id,
            'statue' => fn() => fake()->randomElement(['publié', 'publié', 'publié', 'brouillon']), // Certains articles restent en brouillon
            'favoris' => false, // Jamais en favoris par défaut
        ]);

        // 5. CRÉATION DES COMMENTAIRES
        // On génère 100 commentaires aléatoires sur les articles existants.
        $commentaires = \App\Models\Commentaire::factory(100)->recycle($users)->recycle($articles)->create();

        // 6. CRÉATION DES MENTIONS
        // On simule 30 mentions dans les commentaires.
        \App\Models\Mention::factory(30)
            ->recycle($commentaires)
            ->create();

        $this->command->info('✅ testSeeder a terminé avec succès avec des catégories uniques.');
    }
}