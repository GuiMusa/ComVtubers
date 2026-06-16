<?php

namespace App\Http\view\composer;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;

class SidebarComposer
{
    /**
     * Lier des données à la vue.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $userArticles = collect(); // Collection vide par défaut
        $favoriteArticles = collect(); // Pour les articles favoris
        $lastViewedArticles = collect(); // Pour les articles vus récemment

        if (Auth::check()) {
            $userId = Auth::id();

            // Récupérer les articles de l'utilisateur connecté
            // Seulement les publiés si c'est pour l'affichage (sauf si on est sur son dashboard)
            // Ici le sidebar montre les articles récents de l'utilisateur
            $userArticles = Article::with('user', 'categorie')
                                   ->where('user_id', $userId)
                                   ->where('statue', 'publié') // On cache les brouillons
                                   ->orderBy('date', 'desc')
                                   ->take(10)
                                   ->get(); 

            // Récupérer les 10 derniers articles favoris de l'utilisateur
            // Uniquement si l'article est publié (pas brouillon)
            $favoriteArticles = Article::with('user', 'categorie')
                                       ->where('user_id', $userId)
                                       ->where('favoris', true)
                                       ->where('statue', 'publié')
                                       ->orderBy('date', 'desc')
                                       ->take(10)
                                       ->get();
        }
        
        // 10article vues pas encore creer 
        $view->with(compact('userArticles', 'favoriteArticles', 'lastViewedArticles'));
    }
}
