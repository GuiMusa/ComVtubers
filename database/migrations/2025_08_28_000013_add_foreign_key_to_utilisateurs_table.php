<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('utilisateurs', function (Blueprint $table) {
            $table->foreign('ID_article')->references('id')->on('articles')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('utilisateurs', function (Blueprint $table) {
            // Laravel génère un nom de contrainte conventionnel que nous pouvons supprimer en utilisant le nom de la colonne.
            $table->dropForeign(['ID_article']);
        });
    }
};
