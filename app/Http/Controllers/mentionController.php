<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mention;
use App\Models\Commentaire;

class mentionController extends Controller
{
    /**
     * Enregistrer une nouvelle réponse (mention) à un commentaire.
     */
    public function store(Request $request, Commentaire $commentaire)
    {
        // Validation des données
        $validated = $request->validate([
            'reponse' => 'required|string|max:1000',
        ]);

        // Création de la mention (réponse)
        Mention::create([
            'contenu' => $validated['reponse'],
            'date' => now(),
            'user_id' => auth()->id(), // Make sure user_id is set for mentions
            'commentaire_id' => $commentaire->id,
        ]);

        // Redirection vers l'article avec message de succès
        return redirect()->route('articles.show', $commentaire->article_id)
            ->with('success', 'Votre réponse a été publiée avec succès !');
    }

    /**
     * Supprimer une mention.
     */
    public function destroy(Mention $mention)
    {
        $this->authorize('delete', $mention);

        $mention->delete();

        return back()->with('success', 'Votre réponse a été supprimée.');
    }

    /**
     * Mettre à jour une mention.
     */
    public function update(Request $request, Mention $mention)
    {
        $this->authorize('update', $mention);

        $validated = $request->validate([
            'reponse' => 'required|string|max:1000',
        ]);

        $mention->update([
            'contenu' => $validated['reponse'],
        ]);

        return redirect()->route('articles.show', $mention->commentaire->article_id)
            ->with('success', 'Votre réponse a été modifiée avec succès !');
    }
}
