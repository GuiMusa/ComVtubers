<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            
            // Identité
            $table->string('name'); // Nom d'affichage
            $table->string('username')->unique()->nullable(); // Pseudo unique (ex: @user1)
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            
            // Profil
            $table->string('photo_de_profil')->nullable();
            $table->text('bio')->nullable(); // Courte biographie
            $table->json('preferences')->nullable(); // Choix UI (dark mode, etc.)
            
            // Gestion des droits (Séparation Rôle / Statut)
            $table->enum('role', ['user', 'moderator', 'admin'])->default('user');
            $table->boolean('is_admin')->default(false); // Accès rapide aux super-pouvoirs
            $table->enum('status', ['actif', 'banni', 'inactif'])->default('actif');
            
            // Suivi de l'activité
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip', 45)->nullable();
            
            // Authentification
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes(); // AJOUT : Permet la suppression "douce" (deleted_at)
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
