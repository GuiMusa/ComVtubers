<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    /**
     * La table associée au modèle.
     *
     * @var string
     */
    protected $table = 'articles';

    /**
     * Les attributs qui peuvent être assignés en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date',
        'titre',
        'statue',
        'favoris',
        'ID_commentaire',
    ];

    /**
     * Les attributs qui doivent être convertis vers des types natifs.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'favoris' => 'boolean',
        'date' => 'datetime',
    ];

    /**
     * Obtenir le commentaire auquel l'article est associé.
     * Note : Cette relation (un article appartient à un commentaire) est inhabituelle.
     */
    public function commentaire()
    {
        return $this->belongsTo(Commentaire::class, 'ID_commentaire');
    }

    /**
     * Obtenir les utilisateurs pour cet article.
     * Note : Cette relation (un article a plusieurs utilisateurs) est inhabituelle.
     */
    public function utilisateurs()
    {
        return $this->hasMany(Utilisateur::class, 'ID_article');
    }
}
