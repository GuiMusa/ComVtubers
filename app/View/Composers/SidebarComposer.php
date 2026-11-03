<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;

class SidebarComposer
{
    public function compose(View $view)
    {
        // 1. Derniers articles publiés sur le site
        //    (affiché sous le nom "Derniers vus" dans la sidebar)
        $latestArticles = Article::visible()
                                 ->with('user', 'categorie')
                                 ->orderBy('date', 'desc')
                                 ->take(5)
                                 ->get();

        // 2. Initialisation
        $userArticles = collect();
        $favoriteArticles = collect(); // Gardé pour plus tard

        // 3. Données de l'utilisateur connecté
        if (Auth::check()) {
            $userId = Auth::id();

            // Mes articles
            $userArticles = Article::with('user', 'categorie')
                                   ->where('user_id', $userId)
                                   ->where('statue', 'publié')
                                   ->orderBy('date', 'desc')
                                   ->take(5)
                                   ->get();

            // Favoris (pour future utilisation, non affiché pour l'instant)
            $favoriteArticles = Article::with('user', 'categorie')
                                       ->where('user_id', $userId)
                                       ->where('favoris', true)
                                       ->where('statue', 'publié')
                                       ->orderBy('date', 'desc')
                                       ->take(5)
                                       ->get();
        }

        // 4. Envoi à la vue
        $view->with(compact(
            'userArticles',
            'favoriteArticles',
            'latestArticles'
        ));
    }
}