<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->string('titre');
            $table->string('image')->nullable();
            $table->enum('statue', ['brouillon', 'publié', 'archivé'])->default('brouillon');
            $table->boolean('favoris')->default(false);
            $table->foreignId('utilisateur_id')->constrained('utilisateurs')->onDelete('cascade');
            $table->foreignId('liste_id')->constrained('listes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('articles');
    }
};