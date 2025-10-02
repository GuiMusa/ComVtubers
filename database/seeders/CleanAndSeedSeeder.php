<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CleanAndSeedSeeder extends Seeder
{
    /**
     * Nettoie complètement la base de données et réexécute les seeders.
     * 
     * Usage: php artisan db:seed --class=CleanAndSeedSeeder
     */
    public function run(): void
    {
        // Désactiver les contraintes de clés étrangères
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Obtenir toutes les tables
        $tables = DB::select('SHOW TABLES');
        $dbName = env('DB_DATABASE');
        
        echo "🗑️  Nettoyage de la base de données...\n";
        
        // Tronquer toutes les tables sauf 'migrations'
        foreach ($tables as $table) {
            $tableName = $table->{"Tables_in_$dbName"};
            
            if ($tableName !== 'migrations') {
                DB::table($tableName)->truncate();
                echo "   ✓ Table '$tableName' nettoyée\n";
            }
        }
        
        // Réactiver les contraintes
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        echo "\n🌱 Exécution des seeders...\n";
        
        // Exécuter le DatabaseSeeder principal
        $this->call([
            DatabaseSeeder::class,
        ]);
        
        echo "\n✅ Base de données réinitialisée avec succès !\n";
    }
}
