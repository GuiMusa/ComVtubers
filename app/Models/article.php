<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    /**
     * La table associée au modèle.
     */
    protected $table = 'articles';

    /**
     * Les attributs qui peuvent être assignés en masse.
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
     */
    protected $casts = [
        'favoris' => 'boolean',
        'date' => 'datetime',
    ];

    /**
     * Scope pour ne récupérer que les articles "visibles" :
     * - Doivent être au statut 'publié'
     * - L'auteur ne doit pas être banni (doit être 'actif' ou 'modérateur')
     */
    public function scopeVisible($query)
    {
        return $query->where('statue', 'publié')
                     ->whereHas('user', function ($q) {
                         $q->whereIn('statue', ['actif', 'modérateur']);
                     });
    }

    /**
     * Relation : Un article appartient à un utilisateur (Auteur).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relation : Un article appartient à une catégorie unique.
     */
    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }

    /**
     * Relation : Un article appartient à une liste (non utilisé pour le moment).
     */
    public function liste()
    {
        return $this->belongsTo(Liste::class, 'liste_id');
    }

    /**
     * Relation : Un article peut avoir plusieurs commentaires.
     */
    public function commentaires()
    {
        return $this->hasMany(Commentaire::class, 'article_id');
    }
}
