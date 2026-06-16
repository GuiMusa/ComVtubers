<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\commentaireController;
use Illuminate\Support\Facades\Route;

/**
 * ROUTES PUBLIQUES
 */

// Page d'accueil : liste des articles
Route::get('/', [ArticleController::class, 'index'])->name('home');

// Affichage d'un article spécifique (visible par tous si publié)
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');


/**
 * ROUTES ARTICLES (Nécessitent d'être connecté)
 */
Route::middleware('auth')->group(function () {
    // Formulaire de création
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    // Enregistrement de l'article
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    
    // Formulaire de modification
    Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    // Mise à jour (PATCH est préféré pour une modification partielle)
    Route::patch('/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
    // Suppression
    Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');
});


/**
 * ROUTES COMMENTAIRES (Nécessitent d'être connecté)
 */
Route::middleware('auth')->group(function () {
    // Ajout d'un commentaire ou d'une réponse
    Route::post('/articles/{article}/commentaires', [commentaireController::class, 'store'])->name('commentaires.store');
    // Mise à jour d'un commentaire
    Route::patch('/commentaires/{commentaire}', [commentaireController::class, 'update'])->name('commentaires.update');
    // Suppression d'un commentaire
    Route::delete('/commentaires/{commentaire}', [commentaireController::class, 'destroy'])->name('commentaires.destroy');
});


/**
 * ROUTES PROFIL (Générées par Breeze)
 */
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Inclusion des routes d'authentification (login, register, etc.)
require __DIR__.'/auth.php';
