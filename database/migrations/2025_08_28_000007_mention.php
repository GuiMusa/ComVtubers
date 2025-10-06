<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mentions', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->text('contenu');
            $table->foreignId('commentaire_id')->constrained('commentaires')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mentions');
    }
};