<?php

namespace App\View\Composers;

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
        // ============================================
        // 1. DERNIERS ARTICLES PUBLIÉS (tout le site)
        // ============================================
        $latestArticles = Article::visible()
                                 ->with('user', 'categorie')
                                 ->orderBy('date', 'desc')
                                 ->take(5)
                                 ->get();

        // ============================================
        // 2. INITIALISATION DES COLLECTIONS (par défaut vides)
        // ============================================
        $userArticles = collect();
        $favoriteArticles = collect();
        $lastViewedArticles = collect();

        // ============================================
        // 3. DONNÉES SPÉCIFIQUES À L'UTILISATEUR CONNECTÉ
        // ============================================
        if (Auth::check()) {
            $userId = Auth::id();

            // --- Mes articles (les 5 derniers publiés par l'utilisateur) ---
            $userArticles = Article::with('user', 'categorie')
                                   ->where('user_id', $userId)
                                   ->where('statue', 'publié')
                                   ->orderBy('date', 'desc')
                                   ->take(5)
                                   ->get();

            // --- Mes articles favoris ---
            $favoriteArticles = Article::with('user', 'categorie')
                                       ->where('user_id', $userId)
                                       ->where('favoris', true)
                                       ->where('statue', 'publié')
                                       ->orderBy('date', 'desc')
                                       ->take(5)
                                       ->get();
        }

        // ============================================
        // 4. DERNIERS ARTICLES VUS (via la session)
        // ============================================
        $viewedIds = session()->get('viewed_articles', []);

        if (!empty($viewedIds)) {
            $lastViewedArticles = Article::visible()
                                         ->whereIn('id', $viewedIds)
                                         ->with('user', 'categorie')
                                         ->get()
                                         // On trie selon l'ordre de la session (le plus récent en premier)
                                         ->sortBy(function ($article) use ($viewedIds) {
                                             return array_search($article->id, $viewedIds);
                                         })
                                         ->values();
        }

        // ============================================
        // 5. ENVOI DES DONNÉES À LA VUE
        // ============================================
        $view->with(compact(
            'userArticles',
            'favoriteArticles',
            'latestArticles',
            'lastViewedArticles'
        ));
    }
}