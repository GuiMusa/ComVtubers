<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->string('nom');
            $table->string('pseudo');
            $table->string('photo_de_profil')->nullable();
            $table->string('mail')->unique();
            $table->string('mdp');
            $table->string('statue');
            $table->foreignId('ID_article')->nullable()->constrained('articles')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('utilisateurs');
    }
};