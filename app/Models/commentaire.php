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
        'user_id',
        'article_id',
        'parent_id',
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
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Obtenir l'article auquel le commentaire est associé.
     */
    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }

    /**
     * Obtenir le commentaire parent (si c'est une réponse).
     */
    public function parent()
    {
        return $this->belongsTo(Commentaire::class, 'parent_id');
    }

    /**
     * Obtenir les réponses à ce commentaire.
     */
    public function reponses()
    {
        return $this->hasMany(Commentaire::class, 'parent_id')->orderBy('date', 'asc');
    }

    /**
     * Obtenir les mentions pour ce commentaire.
     */
    public function mentions()
    {
        return $this->hasMany(Mention::class, 'commentaire_id');
    }
}
