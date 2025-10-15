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
        $articles = Article::with('utilisateur', 'categories')
                           ->orderBy('date', 'desc')
                           ->paginate(10);

        // Articles recommandés (aléatoires) pour la barre latérale droite
        $recommendedArticles = Article::with('utilisateur', 'categories')
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
    $recommendedArticles = Article::with('utilisateur', 'categories')
                                  ->inRandomOrder()
                                  ->where('statue', 'publié')
                                  ->take(5)
                                  ->get();

    return view('createArticle', compact('recommendedArticles', 'categories'));
}

}
