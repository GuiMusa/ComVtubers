<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            // Ajouter la colonne 'contenu' si elle n'existe pas
            if (!Schema::hasColumn('articles', 'contenu')) {
                $table->text('contenu')->after('titre');
            }

            // Gérer la colonne 'media'
            if (Schema::hasColumn('articles', 'image')) {
                $table->renameColumn('image', 'media');
            } elseif (!Schema::hasColumn('articles', 'media')) {
                $table->string('media')->nullable()->after('contenu');
            }
        });
    }

    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            if (Schema::hasColumn('articles', 'media')) {
                $table->renameColumn('media', 'image');
            }
            if (Schema::hasColumn('articles', 'contenu')) {
                $table->dropColumn('contenu');
            }
        });
    }
};
