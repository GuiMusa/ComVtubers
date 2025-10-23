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
            // avec le statut 'publié' ou 'brouillon'
            $userArticles = Article::with('user', 'categories')
                                   ->where('user_id', $userId)
                                   ->whereIn('statue', ['publié', 'brouillon'])
                                   ->orderBy('date', 'desc')
                                   ->take(10) // Ajout pour limiter à 10 articles
                                   ->get(); 

            // Récupérer les 10 derniers articles favoris de l'utilisateur
            $favoriteArticles = Article::with('user', 'categories')
                                       ->where('user_id', $userId)
                                       ->where('favoris', true)
                                       ->orderBy('date', 'desc')
                                       ->take(10)
                                       ->get();
        }
        
        // 10article vues pas encore creer 
        $view->with(compact('userArticles', 'favoriteArticles', 'lastViewedArticles'));
    }
}
