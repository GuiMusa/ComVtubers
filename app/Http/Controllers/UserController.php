<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //afficher 10 dernier articles
     public function index()
    {
        // Récupérer les 10 derniers articles avec pagination
        $articles = Article::with('user', 'categories') // Pré-chargement des relations
                           ->where('statue', 'publié') // Filtrer par statut 'publié' pour la vue publique
                           ->orderBy('date', 'desc')
                           ->paginate(10);
        
        return view('articles.index', compact('articles'));
    }
}
