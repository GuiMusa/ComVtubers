<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Ajouter la colonne categorie_id à la table articles
        Schema::table('articles', function (Blueprint $table) {
            $table->foreignId('categorie_id')->nullable()->constrained('categories')->onDelete('set null');
        });

        // 2. Supprimer la colonne article_id de la table categories
        Schema::table('categories', function (Blueprint $table) {
            if (Schema::hasColumn('categories', 'article_id')) {
                // On doit d'abord supprimer la clé étrangère si elle existe
                $table->dropForeign(['article_id']);
                $table->dropColumn('article_id');
            }
        });
    }

    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->foreignId('article_id')->nullable()->constrained('articles')->onDelete('cascade');
        });

        Schema::table('articles', function (Blueprint $table) {
            $table->dropForeign(['categorie_id']);
            $table->dropColumn('categorie_id');
        });
    }
};
