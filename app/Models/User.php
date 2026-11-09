<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'photo_de_profil',
        'email',
        'password',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Scope pour ne récupérer que les utilisateurs actifs.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'actif')->orwhere('status', 'modérateur');
    }

    /**
     * Obtenir tous les articles de l'utilisateur.
     */
    public function articles()
    {
        return $this->hasMany(Article::class, 'user_id');
    }

    /**
     * Obtenir tous les commentaires de l'utilisateur.
     */
    public function commentaires()
    {
        return $this->hasMany(Commentaire::class, 'user_id');
    }
}
