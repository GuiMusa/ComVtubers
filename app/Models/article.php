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
        'image',
        'statue',
        'favoris',
        'user_id',
        'liste_id',
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
     * Obtenir l'utilisateur qui a créé l'article.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Obtenir la liste à laquelle l'article appartient.
     */
    public function liste()
    {
        return $this->belongsTo(Liste::class, 'liste_id');
    }

    /**
     * Obtenir les commentaires de l'article.
     */
    public function commentaires()
    {
        return $this->hasMany(Commentaire::class, 'article_id');
    }

    /**
     * Obtenir les catégories associées à l'article.
     */
    public function categories()
    {
        return $this->hasMany(Categorie::class, 'article_id');
    }
}
