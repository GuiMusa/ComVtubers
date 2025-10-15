<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;

Route::get('/', [ArticleController::class, 'index'])->name('home');

// Route pour afficher le formulaire de création d'un article
Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');

// Route pour traiter la soumission du formulaire de création
Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');