<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class testSeeder extends Seeder
{
    public function run(): void
    {
        // Désactiver temporairement les contraintes de clés étrangères
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Nettoyer les tables avant d'insérer (optionnel, décommenter si nécessaire)
        // \App\Models\Categorie::truncate();
        // \App\Models\Liste::truncate();
        // \App\Models\Commentaire::truncate();
        // \App\Models\Article::truncate();
        // \App\Models\Utilisateur::truncate();
        // \App\Models\Carte::truncate();
        // \App\Models\Mention::truncate();
        
        // Création dans l'ordre pour respecter les relations
        // 1. D'abord les tables sans dépendances
        \App\Models\Mention::factory(50)->create();
        \App\Models\Carte::factory(20)->create();
        
        // 2. Ensuite les utilisateurs (dépendent d'articles mais on met null pour l'instant)
        \App\Models\Utilisateur::factory(50)->create();
        
        // 3. Les articles (dépendent de commentaires mais on met null)
        \App\Models\Article::factory(100)->create();
        
        // 4. Les commentaires (dépendent d'utilisateurs et mentions)
        \App\Models\Commentaire::factory(200)->create();
        
        // 5. Les listes (dépendent d'articles)
        \App\Models\Liste::factory(30)->create();
        
        // 6. Les catégories (dépendent de cartes)
        \App\Models\Categorie::factory(40)->create();
        
        // Réactiver les contraintes de clés étrangères
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}