<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class utilisateurController extends Controller
{
    //afficher 10 dernier articles
     public function index()
    {
        // Récupérer les 10 derniers articles avec pagination
        $articles = Article::with('utilisateur', 'categories') // Pré-chargement des relations
                           ->where('statue', 'actif') // Si vous voulez filtrer par statut
                           ->orderBy('date', 'desc')
                           ->paginate(10);
        
        return view('index', compact('articles'));
    }
}
