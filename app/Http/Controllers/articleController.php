<?php

namespace App\Http\Controllers;

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
}