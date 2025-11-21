<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\commentaireController;
use App\Http\Controllers\mentionController;
use Illuminate\Support\Facades\Route;

// On remplace la route par défaut de Breeze par la vôtre pour la page d'accueil.
Route::get('/', [ArticleController::class, 'index'])->name('home');

// On déplace également vos autres routes d'articles ici.
// Route pour afficher le formulaire de création d'un article
Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
// Route pour traiter la soumission du formulaire de création
Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
// Route pour afficher un article avec ses commentaires
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');
// Route pour créer un commentaire
Route::post('/articles/{article}/commentaires', [commentaireController::class, 'store'])->name('commentaires.store');
// Route pour créer une réponse (mention) à un commentaire
Route::post('/commentaires/{commentaire}/mentions', [mentionController::class, 'store'])->name('mentions.store');
// Route pour supprimer un commentaire
Route::delete('/commentaires/{commentaire}', [commentaireController::class, 'destroy'])->name('commentaires.destroy')->middleware('auth');
// Route pour traiter la soumission du formulaire de modification d'un commentaire
Route::patch('/commentaires/{commentaire}', [commentaireController::class, 'update'])->name('commentaires.update')->middleware('auth');

// Routes pour les mentions (réponses de commentaires)
Route::delete('/mentions/{mention}', [mentionController::class, 'destroy'])->name('mentions.destroy')->middleware('auth');
Route::patch('/mentions/{mention}', [mentionController::class, 'update'])->name('mentions.update')->middleware('auth');

// Routes pour la gestion des articles (édition, mise à jour, suppression)
Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit')->middleware('auth');
Route::patch('/articles/{article}', [ArticleController::class, 'update'])->name('articles.update')->middleware('auth');
Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy')->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
