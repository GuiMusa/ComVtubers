<?php

namespace App\Providers;

use App\Http\view\composer\SidebarComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
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
        View::composer(
            'layouts.Lsidebar',
            SidebarComposer::class
        );
    }
}
