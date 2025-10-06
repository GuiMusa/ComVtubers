<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CleanAndSeedSeeder extends Seeder
{
    /**
     * Nettoie les tables et réexécute les seeders principaux.
     * NOTE : Il est souvent préférable d'utiliser `php artisan migrate:fresh --seed`.
     *
     * @return void
     */
    public function run(): void
    {
        if ($this->command->getOutput()->isQuiet()) {
            $this->runSilent();
        } else {
            $this->runVerbose();
        }
    }

    private function runVerbose(): void
    {
        $this->command->warn('Cette commande va vider toutes vos tables. La commande `migrate:fresh --seed` est souvent une meilleure alternative.');
        if (!$this->command->confirm('Voulez-vous continuer ?')) {
            $this->command->info('Opération annulée.');
            return;
        }

        $this->command->call('db:wipe');
        $this->command->call('migrate');
        $this->command->call('db:seed');
    }

    private function runSilent(): void
    {
        Schema::disableForeignKeyConstraints();
        \App\Models\Mention::truncate();
        \App\Models\Categorie::truncate();
        \App\Models\Commentaire::truncate();
        \App\Models\Article::truncate();
        \App\Models\Liste::truncate();
        \App\Models\Carte::truncate();
        \App\Models\Utilisateur::truncate();
        Schema::enableForeignKeyConstraints();

        $this->call(DatabaseSeeder::class);
    }
}
