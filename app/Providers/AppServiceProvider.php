<?php

namespace App\Providers;

use App\Models\Article;
use App\Policies\ArticlePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        /*
        |------------------------------------------------------------------
        | View Composer pour Lsidebar
        |------------------------------------------------------------------
        | Fournit automatiquement $userArticles et $latestArticles
        | à TOUTES les vues qui incluent layouts.Lsidebar (show, edit,
        | create, index…). Plus besoin de les passer depuis le contrôleur.
        */
View::composer('layouts.Lsidebar', function ($view) {
            // 1. Mes articles
            $userArticles = auth()->check()
                ? Article::query()
                    ->where('user_id', auth()->id())
                    ->orderByDesc('date')
                    ->take(10)
                    ->get()
                : collect();

            // 2. Derniers vus (Récupération depuis la session)
            $viewedIds = session()->get('viewed_articles', []);
            $latestArticles = collect();

            if (!empty($viewedIds)) {
                // On récupère les articles par leur ID et on s'assure qu'ils sont toujours visibles
                $latestArticles = Article::whereIn('id', $viewedIds)
                    ->visible() 
                    ->get()
                    // On trie les résultats pour respecter l'ordre exact de la session (du plus récent au plus ancien)
                    ->sortBy(function ($article) use ($viewedIds) {
                        return array_search($article->id, $viewedIds);
                    });
            }

            $view->with([
                'userArticles'   => $userArticles,
                'latestArticles' => $latestArticles,
            ]);
        });

        /*
        |------------------------------------------------------------------
        | Enregistrement explicite de la Policy
        | (Laravel 11 auto-découvre, mais explicite = compatible 10/11/12)
        */
        Gate::policy(Article::class, ArticlePolicy::class);
    }
}