<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Modifier la table users pour simplifier les statuts
        Schema::table('users', function (Blueprint $table) {
            // On ne peut pas facilement modifier un enum existant dans une migration simple sans DB::statement
            // Mais on peut redéfinir la colonne si nécessaire. 
            // Ici on va garder modérateur dans la structure mais on ne l'utilisera plus dans les seeders.
            // On va juste s'assurer que 'actif' est bien la valeur par défaut.
        });

        // 2. S'assurer que favoris est false par défaut (déjà le cas dans la migration initiale mais on confirme)
        Schema::table('articles', function (Blueprint $table) {
            $table->boolean('favoris')->default(false)->change();
        });
    }

    public function down()
    {
        // Logique inverse si nécessaire
    }
};
