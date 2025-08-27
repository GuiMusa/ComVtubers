<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Création dans l'ordre pour respecter les relations
        \App\Models\Mention::factory(50)->create();
        \App\Models\Carte::factory(20)->create();
        \App\Models\Article::factory(100)->create();
        \App\Models\Utilisateur::factory(50)->create();
        \App\Models\Liste::factory(30)->create();
        \App\Models\Categorie::factory(40)->create();
        \App\Models\Commentaire::factory(200)->create();
    }
}