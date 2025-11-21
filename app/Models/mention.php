<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mention extends Model
{
    use HasFactory;

    /**
     * La table associée au modèle.
     *
     * @var string
     */
    protected $table = 'mentions';

    /**
     * Les attributs qui peuvent être assignés en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date',
        'contenu',
        'commentaire_id',
        'user_id',
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
     * Obtenir le commentaire auquel la mention appartient.
     */
    public function commentaire()
    {
        return $this->belongsTo(Commentaire::class, 'commentaire_id');
    }

    /**
     * Obtenir l'utilisateur qui a créé la mention.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
