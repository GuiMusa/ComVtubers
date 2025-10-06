<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Utilisateur extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * La table associée au modèle.
     *
     * @var string
     */
    protected $table = 'utilisateurs';

    /**
     * Les attributs qui peuvent être assignés en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date',
        'nom',
        'pseudo',
        'photo_de_profil',
        'mail',
        'mdp',
        'statue',
    ];

    /**
     * Les attributs qui doivent être cachés pour la sérialisation.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'mdp',
    ];

    /**
     * Récupère le mot de passe pour l'utilisateur.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->mdp;
    }

    /**
     * Obtenir les commentaires de l'utilisateur.
     */
    public function commentaires()
    {
        return $this->hasMany(Commentaire::class, 'utilisateur_id');
    }

    /**
     * Obtenir les articles créés par l'utilisateur.
     */
    public function articles()
    {
        return $this->hasMany(Article::class, 'utilisateur_id');
    }
}
