<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    use HasFactory;

    /**
     * La table associée au modèle.
     *
     * @var string
     */
    protected $table = 'commentaires';

    /**
     * Les attributs qui peuvent être assignés en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date',
        'contenu',
        'image',
        'ID_utilisateur',
        'ID_mention',
    ];

    /**
     * Les attributs qui doivent être convertis vers des types natifs.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'datetime',
    ];

    /**
     * Obtenir l'utilisateur qui a posté le commentaire.
     */
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'ID_utilisateur');
    }

    /**
     * Obtenir la mention associée au commentaire.
     */
    public function mention()
    {
        return $this->belongsTo(Mention::class, 'ID_mention');
    }

    /**
     * Obtenir les articles pour ce commentaire.
     * Note : Cette relation (un commentaire a plusieurs articles) est inhabituelle.
     */
    public function articles()
    {
        return $this->hasMany(Article::class, 'ID_commentaire');
    }
}
