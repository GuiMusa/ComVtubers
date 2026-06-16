<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Commentaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class commentaireController extends Controller
{
    /**
     * Enregistre un nouveau commentaire ou une réponse.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Article $article)
    {
        // 1. Validation des données entrantes
        $request->validate([
            'contenu' => 'required|string|max:1000', // Le contenu est obligatoire et limité à 1000 caractères
            'parent_id' => 'nullable|exists:commentaires,id', // parent_id est optionnel, mais s'il existe, il doit être valide
        ]);

        // 2. Création du commentaire en base de données
        Commentaire::create([
            'contenu' => $request->contenu,
            'date' => now(), // Date actuelle
            'user_id' => Auth::id(), // ID de l'utilisateur connecté
            'article_id' => $article->id, // Liaison avec l'article
            'parent_id' => $request->parent_id, // Si c'est une réponse, parent_id sera rempli
        ]);

        // 3. Définition du message de succès selon qu'il s'agit d'une réponse ou d'un commentaire direct
        $message = $request->parent_id ? 'Votre réponse a été ajoutée !' : 'Votre commentaire a été ajouté !';

        // 4. Redirection vers la page précédente avec le message de succès
        return back()->with('success', $message);
    }

    /**
     * Met à jour un commentaire existant.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commentaire  $commentaire
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Commentaire $commentaire)
    {
        // 1. Sécurité : On vérifie que l'utilisateur connecté est bien l'auteur du commentaire
        if (Auth::id() !== $commentaire->user_id) {
            return back()->with('error', 'Vous n\'êtes pas autorisé à modifier ce commentaire.');
        }

        // 2. Validation du nouveau contenu
        $request->validate([
            'contenu' => 'required|string|max:1000',
        ]);

        // 3. Mise à jour en base de données
        $commentaire->update([
            'contenu' => $request->contenu,
        ]);

        return back()->with('success', 'Votre commentaire a été mis à jour !');
    }

    /**
     * Supprime un commentaire et ses réponses (en cascade via la DB).
     *
     * @param  \App\Models\Commentaire  $commentaire
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Commentaire $commentaire)
    {
        // 1. Sécurité : Seul l'auteur peut supprimer son commentaire
        if (Auth::id() !== $commentaire->user_id) {
            return back()->with('error', 'Vous n\'êtes pas autorisé à supprimer ce commentaire.');
        }

        // 2. Suppression du commentaire
        // Note : Grâce à onDelete('cascade') dans la migration, les réponses liées sont supprimées automatiquement par SQL
        $commentaire->delete();

        return back()->with('success', 'Votre commentaire a été supprimé !');
    }
}
