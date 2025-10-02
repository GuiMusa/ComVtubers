<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Liste extends Model
{
    use HasFactory;

    /**
     * La table associée au modèle.
     *
     * @var string
     */
    protected $table = 'listes';

    /**
     * Les attributs qui peuvent être assignés en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date',
        'favoris',
        'ID_article',
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
     * Obtenir l'article auquel la liste est associée.
     */
    public function article()
    {
        return $this->belongsTo(Article::class, 'ID_article');
    }
}
