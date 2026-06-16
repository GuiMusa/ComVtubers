<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        // Articles récents pour le contenu principal
        // On n'affiche que les articles publiés d'utilisateurs non bannis
        $articles = Article::visible()
                           ->with('user', 'categorie')
                           ->orderBy('date', 'desc')
                           ->paginate(10);

        // Articles recommandés (aléatoires) pour la barre latérale droite
        $recommendedArticles = Article::visible()
                                      ->with('user', 'categorie')
                                      ->inRandomOrder()
                                      ->take(5)
                                      ->get();

        return view('index', compact('articles', 'recommendedArticles'));
    }
    
    public function create()
    {
        // Récupérer toutes les catégories pour le menu déroulant
        $categories = Categorie::orderBy('nom')->get()->unique('nom');

        // On a besoin des articles recommandés pour la barre latérale droite
        $recommendedArticles = Article::visible()
                                      ->with('user', 'categorie')
                                      ->inRandomOrder()
                                      ->take(5)
                                      ->get();

        return view('createArticle', compact('recommendedArticles', 'categories'));
    }

    public function store(Request $request)
    {
        // 1. Validation des données
        $validatedData = $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'categorie_id' => 'required|exists:categories,id',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi|max:10240', // 10Mo max
        ], [
            'titre.required' => 'Le titre est obligatoire.',
            'contenu.required' => 'Le message est obligatoire.',
            'categorie_id.required' => 'Veuillez choisir une catégorie.',
            'categorie_id.exists' => 'La catégorie sélectionnée est invalide.',
        ]);

        // 2. Gestion de l'upload d'image/média
        $mediaPath = null;
        if ($request->hasFile('media')) {
            $mediaPath = $request->file('media')->store('articles_media', 'public');
        }

        // 3. Création de l'article
        $article = new Article();
        $article->titre = $validatedData['titre'];
        $article->contenu = $validatedData['contenu'];
        $article->media = $mediaPath;
        $article->date = now();
        $article->statue = 'publié'; // Statut par défaut
        $article->user_id = auth()->id();
        $article->liste_id = 1; // Valeur par défaut temporaire
        $article->categorie_id = $validatedData['categorie_id'];
        $article->save();

        // 4. Redirection vers l'accueil avec un message de succès
        return redirect()->route('home')->with('success', 'Votre article a été posté avec succès !');
    }

}
