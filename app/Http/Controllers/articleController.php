<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');

        $articles = Article::visible()
            ->with('user', 'categorie')
            ->when($q, function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('titre', 'like', "%{$q}%")
                        ->orWhere('contenu', 'like', "%{$q}%");
                });
            })
            ->orderBy('date', 'desc')
            ->paginate(10)
            ->withQueryString(); // conserve ?q= dans la pagination

        $recommendedArticles = Article::visible()
            ->with('user', 'categorie')
            ->inRandomOrder()
            ->take(5)
            ->get();

        return view('index', compact('articles', 'recommendedArticles'));
    }

    public function create()
    {
        $this->authorize('create', Article::class);

        $categories = Categorie::orderBy('nom')->get()->unique('nom');
        $recommendedArticles = Article::visible()
            ->with('user', 'categorie')
            ->inRandomOrder()
            ->take(5)
            ->get();

        return view('articles.createArticle', compact('recommendedArticles', 'categories'));
    }

    public function show(Article $article)
    {
        // Remplace le if() manuel : redirige en 404 si non autorisé
        $this->authorize('view', $article);

        // Tracking 5 derniers articles vus
        $viewed = session()->get('viewed_articles', []);
        $viewed = array_filter($viewed, fn ($id) => $id != $article->id);
        array_unshift($viewed, $article->id);
        $viewed = array_slice($viewed, 0, 5);
        session()->put('viewed_articles', $viewed);

        $article->load(['user', 'categorie', 'commentaires.user']);

        $recommendedArticles = Article::visible()
            ->where('id', '!=', $article->id)
            ->with('user', 'categorie')
            ->inRandomOrder()
            ->take(5)
            ->get();

        return view('articles.showArticle', compact('article', 'recommendedArticles'));
    }

    public function store(StoreArticleRequest $request)
    {
        $data = $request->validated();

        $mediaPath = $request->hasFile('media')
            ? $request->file('media')->store('articles_media', 'public')
            : null;

        Article::create([
            'titre'        => $data['titre'],
            'contenu'      => $data['contenu'],
            'media'        => $mediaPath,
            'date'         => now(),
            'statue'       => 'publié',
            'user_id'      => auth()->id(),
            'categorie_id' => $data['categorie_id'],
        ]);

        return redirect()->route('home')
            ->with('success', 'Votre article a été posté avec succès !');
    }

    public function edit(Article $article)
    {
        $this->authorize('update', $article);

        $categories = Categorie::orderBy('nom')->get()->unique('nom');
        $recommendedArticles = Article::visible()
            ->where('id', '!=', $article->id)
            ->with('user', 'categorie')
            ->inRandomOrder()
            ->take(5)
            ->get();

        return view('articles.editArticle', compact('article', 'categories', 'recommendedArticles'));
    }

    public function update(UpdateArticleRequest $request, Article $article)
    {
        // authorize() est déjà fait dans UpdateArticleRequest
        $data = $request->validated();

        if ($request->hasFile('media')) {
            if ($article->media) {
                Storage::disk('public')->delete($article->media);
            }
            $article->media = $request->file('media')->store('articles_media', 'public');
        }

        $article->titre        = $data['titre'];
        $article->contenu      = $data['contenu'];
        $article->categorie_id = $data['categorie_id'];
        $article->save();

        return redirect()->route('articles.show', $article->id)
            ->with('success', 'Votre article a été mis à jour avec succès !');
    }

    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);

        if ($article->media) {
            Storage::disk('public')->delete($article->media);
        }

        $article->delete();

        return redirect()->route('home')
            ->with('success', 'Votre article a été supprimé avec succès.');
    }
}