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
            $table->enum('statue', ['brouillon', 'publié', 'archivé'])->default('brouillon');
            $table->boolean('favoris')->default(false);
            $table->foreignId('ID_commentaire')->nullable()->constrained('commentaires')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('articles');
    }
};