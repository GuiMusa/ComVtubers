<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commentaire;
use App\Models\Article;

class commentaireController extends Controller
{
    /**
     * Enregistrer un nouveau commentaire.
     */
    public function store(Request $request, Article $article)
    {
        // Validation des données
        $validated = $request->validate([
            'commentaire' => 'required|string|max:1000',
        ]);

        // Création du commentaire
        Commentaire::create([
            'contenu' => $validated['commentaire'],
            'date' => now(),
            'user_id' => auth()->id(),
            'article_id' => $article->id,
        ]);

        // Redirection avec message de succès
        return redirect()->route('articles.show', $article)
            ->with('success', 'Votre commentaire a été publié avec succès !');
    }

    /**
     * Supprimer un commentaire.
     */
    public function destroy(Commentaire $commentaire)
    {
        // Vérifier si l'utilisateur est autorisé à supprimer le commentaire
        $this->authorize('delete', $commentaire);

        // Suppression du commentaire
        $commentaire->delete();

        // Redirection avec message de succès
        return back()->with('success', 'Votre commentaire a été supprimé.');
    }

    /**
     * Mettre à jour un commentaire.
     */
    public function update(Request $request, Commentaire $commentaire)
    {
        // Vérifier si l'utilisateur est autorisé à modifier le commentaire
        $this->authorize('update', $commentaire);

        // Validation des données
        $validated = $request->validate([
            'commentaire' => 'required|string|max:1000',
        ]);

        // Mise à jour du commentaire
        $commentaire->update([
            'contenu' => $validated['commentaire'],
        ]);

        // Redirection avec message de succès
        return redirect()->route('articles.show', $commentaire->article)
            ->with('success', 'Votre commentaire a été modifié avec succès !');
    }
}
