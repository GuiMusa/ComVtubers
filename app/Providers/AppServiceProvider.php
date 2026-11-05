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
            $userArticles = auth()->check()
                ? Article::query()
                    ->where('user_id', auth()->id())
                    ->orderByDesc('date')
                    ->take(10)
                    ->get()
                : collect();

            $latestArticles = Article::visible()
                ->orderByDesc('date')
                ->take(5)
                ->get();

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