<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('commentaires', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->text('contenu');
            $table->string('image')->nullable();
            $table->foreignId('ID_utilisateur')->constrained('utilisateurs')->onDelete('cascade');
            $table->foreignId('ID_mention')->nullable()->constrained('mentions')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('commentaires');
    }
};