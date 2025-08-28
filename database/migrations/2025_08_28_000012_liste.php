<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('listes', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->boolean('favoris')->default(false);
            $table->foreignId('ID_article')->constrained('articles')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('listes');
    }
};