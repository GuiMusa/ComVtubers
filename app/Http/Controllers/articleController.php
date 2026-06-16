<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Affiche la page d'accueil avec les articles récents et recommandés.
     */
    public function index()
    {
        // On récupère les articles récents (publiés et d'utilisateurs non bannis)
        $articles = Article::visible()
                           ->with('user', 'categorie')
                           ->orderBy('date', 'desc')
                           ->paginate(10);

        // On récupère 5 articles au hasard pour les recommandations
        $recommendedArticles = Article::visible()
                                      ->with('user', 'categorie')
                                      ->inRandomOrder()
                                      ->take(5)
                                      ->get();

        return view('index', compact('articles', 'recommendedArticles'));
    }
    
    /**
     * Affiche le formulaire de création d'un nouvel article.
     */
    public function create()
    {
        $categories = Categorie::orderBy('nom')->get()->unique('nom');

        $recommendedArticles = Article::visible()
                                      ->with('user', 'categorie')
                                      ->inRandomOrder()
                                      ->take(5)
                                      ->get();

        return view('createArticle', compact('recommendedArticles', 'categories'));
    }

    /**
     * Affiche un article spécifique avec ses commentaires.
     */
    public function show(Article $article)
    {
        // Sécurité : On vérifie que l'article est visible. 
        // S'il est caché/banni, seul l'auteur peut encore y accéder.
        if ($article->statue !== 'publié' || ($article->user && $article->user->statue === 'banni')) {
            if (auth()->id() !== $article->user_id) {
                abort(404, "Cet article n'est pas disponible.");
            }
        }

        $article->load(['user', 'categorie', 'commentaires.user']);

        $recommendedArticles = Article::visible()
                                      ->where('id', '!=', $article->id)
                                      ->with('user', 'categorie')
                                      ->inRandomOrder()
                                      ->take(5)
                                      ->get();

        return view('showArticle', compact('article', 'recommendedArticles'));
    }

    /**
     * Enregistre un nouvel article.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'categorie_id' => 'required|exists:categories,id',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi|max:10240',
        ], [
            'titre.required' => 'Le titre est obligatoire.',
            'contenu.required' => 'Le message est obligatoire.',
            'categorie_id.required' => 'Veuillez choisir une catégorie.',
        ]);

        $mediaPath = null;
        if ($request->hasFile('media')) {
            $mediaPath = $request->file('media')->store('articles_media', 'public');
        }

        $article = new Article();
        $article->titre = $validatedData['titre'];
        $article->contenu = $validatedData['contenu'];
        $article->media = $mediaPath;
        $article->date = now();
        $article->statue = 'publié';
        $article->user_id = auth()->id();
        $article->liste_id = 1; 
        $article->categorie_id = $validatedData['categorie_id'];
        $article->save();

        return redirect()->route('home')->with('success', 'Votre article a été posté avec succès !');
    }

    /**
     * Affiche le formulaire d'édition (uniquement pour l'auteur).
     */
    public function edit(Article $article)
    {
        // 1. Vérification de l'auteur
        if (auth()->id() !== $article->user_id) {
            abort(403, "Vous n'êtes pas autorisé à modifier cet article.");
        }

        $categories = Categorie::orderBy('nom')->get()->unique('nom');
        
        // On récupère quand même des recommandations pour le layout sidebar
        $recommendedArticles = Article::visible()
                                      ->where('id', '!=', $article->id)
                                      ->with('user', 'categorie')
                                      ->inRandomOrder()
                                      ->take(5)
                                      ->get();

        return view('editArticle', compact('article', 'categories', 'recommendedArticles'));
    }

    /**
     * Met à jour l'article.
     */
    public function update(Request $request, Article $article)
    {
        // 1. Vérification de l'auteur
        if (auth()->id() !== $article->user_id) {
            abort(403, "Vous n'êtes pas autorisé à modifier cet article.");
        }

        // 2. Validation
        $validatedData = $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'categorie_id' => 'required|exists:categories,id',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi|max:10240',
        ]);

        // 3. Gestion du nouveau média (si fourni)
        if ($request->hasFile('media')) {
            // Suppression de l'ancien fichier physique pour ne pas encombrer le serveur
            if ($article->media) {
                Storage::disk('public')->delete($article->media);
            }
            // Enregistrement du nouveau fichier
            $article->media = $request->file('media')->store('articles_media', 'public');
        }

        // 4. Mise à jour des autres champs
        $article->titre = $validatedData['titre'];
        $article->contenu = $validatedData['contenu'];
        $article->categorie_id = $validatedData['categorie_id'];
        $article->save();

        return redirect()->route('articles.show', $article->id)->with('success', 'Votre article a été mis à jour avec succès !');
    }

    /**
     * Supprime l'article.
     */
    public function destroy(Article $article)
    {
        // 1. Vérification de l'auteur
        if (auth()->id() !== $article->user_id) {
            abort(403, "Vous n'êtes pas autorisé à supprimer cet article.");
        }

        // 2. Suppression du fichier média associé
        if ($article->media) {
            Storage::disk('public')->delete($article->media);
        }

        // 3. Suppression de l'article en base de données
        $article->delete();

        return redirect()->route('home')->with('success', 'Votre article a été supprimé avec succès.');
    }
}
