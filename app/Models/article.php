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
        'contenu',
        'media',
        'statue',
        'favoris',
        'user_id',
        'liste_id',
        'categorie_id',
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
     * Scope pour ne récupérer que les articles publiés d'utilisateurs non bannis.
     */
    public function scopeVisible($query)
    {
        return $query->where('statue', 'publié')
                     ->whereHas('user', function ($q) {
                         $q->whereIn('statue', ['actif', 'modérateur']);
                     });
    }

    /**
     * Obtenir l'utilisateur qui a créé l'article.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Obtenir la catégorie de l'article.
     */
    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
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
}
