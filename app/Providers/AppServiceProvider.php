<?php

namespace App\Providers;

use App\View\Composers\SidebarComposer; 
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public const HOME = '/';   // → mettre '/'
    
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Utiliser un View Composer pour partager les données avec la barre latérale.
        // Ceci est exécuté chaque fois que la vue 'layouts.Lsidebar' est rendue.
        // View::composer(
        //     'layouts.Lsidebar',
        //     SidebarComposer::class
        // );
        View::composer('layouts.Lsidebar', function ($view) {
    $view->with([
        'userArticles'    => auth()->check()
            ? \App\Models\Article::where('user_id', auth()->id())->latest('date')->take(10)->get()
            : collect(),
        'latestArticles'  => \App\Models\Article::visible()->latest('date')->take(5)->get(),
    ]);
});
    }
}