<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index()
    {
        // Articles récents pour le contenu principal
        $articles = Article::with('user', 'categories')
                           ->orderBy('date', 'desc')
                           ->where('statue', 'publié')
                           ->paginate(10);

        // Articles recommandés (aléatoires) pour la barre latérale droite
        $recommendedArticles = Article::with('user', 'categories')
                                      ->inRandomOrder()
                                      ->where('statue', 'publié') // On ne recommande que les articles publiés
                                      ->take(5)
                                      ->get();

        return view('index', compact('articles', 'recommendedArticles'));
    }
    
    public function create()
{
    // Récupérer toutes les catégories pour le menu déroulant
    $categories = Categorie::orderBy('nom')->get()->unique('nom');

    // On a besoin des articles recommandés pour la barre latérale droite,
    // qui est incluse dans la vue 'createArticle'.
    $recommendedArticles = Article::with('user', 'categories')
                                  ->inRandomOrder()
                                  ->where('statue', 'publié')
                                  ->take(5)
                                  ->get();

    return view('createArticle', compact('recommendedArticles', 'categories'));
}

public function store(Request $request)
{
    // 1. Valider les données du formulaire
    $validatedData = $request->validate([
        'titre' => 'required|string|max:255',
        'contenu' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Image optionnelle
        'categories' => 'nullable|array', // Les catégories sont optionnelles
        'categories.*' => 'exists:categories,id' // S'assurer que les IDs de catégories existent
    ]);

    // 2. Gérer l'upload de l'image si elle est présente
    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('articles', 'public');
    }

    // 3. Créer l'article
    $article = Article::create([
        'user_id' => Auth::id(), // Associer l'article à l'utilisateur connecté
        'titre' => $validatedData['titre'],
        'contenu' => $validatedData['contenu'],
        'image' => $imagePath,
        'date' => now(), // Date de publication actuelle
        'liste_id' => null, // Ajout pour éviter l'erreur SQL
        'statue' => 'publié', // Ou 'brouillon' selon votre logique
    ]);

    // 4. Attacher les catégories à l'article
    if (!empty($validatedData['categories'])) {
        $article->categories()->attach($validatedData['categories']);
    }

    // 5. Rediriger avec un message de succès
    return redirect()->route('home')->with('success', 'Article créé avec succès !');
}

}
