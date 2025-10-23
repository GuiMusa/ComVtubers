<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;

// On remplace la route par défaut de Breeze par la vôtre pour la page d'accueil.
Route::get('/', [ArticleController::class, 'index'])->name('home');

// On déplace également vos autres routes d'articles ici.
// Route pour afficher le formulaire de création d'un article
Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
// Route pour traiter la soumission du formulaire de création
Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
