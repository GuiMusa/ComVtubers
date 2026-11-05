<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ArticlePolicy
{
    /**
     * Voir un article : reprend EXACTEMENT la logique de ton show().
     * - Article publié + auteur non banni → visible par tous
     * - Sinon → seul l'auteur peut le voir (brouillon)
     */
    public function view(?User $user, Article $article): Response
    {
        $isPublic = $article->statue === 'publié'
            && (!$article->user || $article->user->statue !== 'banni');

        if ($isPublic) {
            return Response::allow();
        }

        return ($user && $user->id === $article->user_id)
            ? Response::allow()
            : Response::denyAsNotFound("Cet article n'est pas disponible.");
    }

    /**
     * Créer : interdit aux utilisateurs bannis.
     */
    public function create(User $user): bool
    {
        return $user->statue !== 'banni';
    }

    /**
     * Modifier : auteur uniquement.
     */
    public function update(User $user, Article $article): bool
    {
        return $user->id === $article->user_id;
    }

    /**
     * Supprimer : auteur uniquement.
     */
    public function delete(User $user, Article $article): bool
    {
        return $user->id === $article->user_id;
    }
}