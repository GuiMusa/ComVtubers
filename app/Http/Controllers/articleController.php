<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        // Articles récents pour le contenu principal
        $articles = Article::with('user', 'categories')
                           ->orderBy('date', 'desc')
                           ->where('statue', 'publié')
                           ->paginate(10);

        if ($request->ajax()) {
            $articlesHtml = '';
            foreach ($articles as $article) {
                $articlesHtml .= view('partials._article-card', ['article' => $article])->render();
            }
            return response()->json([
                'articles_html' => $articlesHtml,
                'next_page_url' => $articles->nextPageUrl()
            ]);
        }

        // Articles recommandés (aléatoires) pour la barre latérale droite
        $recommendedArticles = Article::with('user', 'categories')
                                      ->inRandomOrder()
                                      ->where('statue', 'publié') // On ne recommande que les articles publiés
                                      ->take(5)
                                      ->get();

        return view('index', compact('articles', 'recommendedArticles'));
    }
    
    public function create()
{
    // Récupérer toutes les catégories pour le menu déroulant
    $categories = Categorie::orderBy('nom')->get()->unique('nom');

    // On a besoin des articles recommandés pour la barre latérale droite,
    // qui est incluse dans la vue 'createArticle'.
    $recommendedArticles = Article::with('user', 'categories')
                                  ->inRandomOrder()
                                  ->where('statue', 'publié')
                                  ->take(5)
                                  ->get();

    return view('createArticle', compact('recommendedArticles', 'categories'));
}

public function store(Request $request)
{
    // 1. Valider les données du formulaire
    $validatedData = $request->validate([
        'titre' => 'required|string|max:255',
        'contenu' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Image optionnelle
        'categories' => 'nullable|array', // Les catégories sont optionnelles
        'categories.*' => 'exists:categories,id' // S'assurer que les IDs de catégories existent
    ]);

    // 2. Gérer l'upload de l'image si elle est présente
    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('articles', 'public');
    }

    // 3. Créer l'article
    $article = Article::create([
        'user_id' => Auth::id(), // Associer l'article à l'utilisateur connecté
        'titre' => $validatedData['titre'],
        'contenu' => $validatedData['contenu'],
        'image' => $imagePath,
        'date' => now(), // Date de publication actuelle
        'statue' => 'publié', // Ou 'brouillon' selon votre logique
    ]);

    // 4. Attacher les catégories à l'article
    if (!empty($validatedData['categories'])) {
        $article->categories()->attach($validatedData['categories']);
    }

    // 5. Rediriger avec un message de succès
    return redirect()->route('home')->with('success', 'Article créé avec succès !');
}

    public function show(Article $article, Request $request)
    {
        // Charger l'article avec ses relations
        $article->load('user', 'categories', 'commentaires.user');

        // Articles recommandés pour la barre latérale droite
        $recommendedArticles = Article::with('user', 'categories')
                                      ->where('id', '!=', $article->id) // Exclure l'article actuel
                                      ->inRandomOrder()
                                      ->where('statue', 'publié')
                                      ->take(5)
                                      ->get();

        // Logique pour les articles récemment vus
        $lastViewedArticles = $request->session()->get('last_viewed_articles', []);

        // Ajouter l'ID de l'article actuel au début de la liste
        // S'assurer qu'il est unique et limiter la taille
        $lastViewedArticles = array_values(array_unique(array_merge([$article->id], $lastViewedArticles)));
        $lastViewedArticles = array_slice($lastViewedArticles, 0, 5); // Limiter à 5 articles

        $request->session()->put('last_viewed_articles', $lastViewedArticles);

        return view('showArticle', compact('article', 'recommendedArticles'));
    }



    public function edit(Article $article)

    {

        $this->authorize('update', $article);



        $categories = Categorie::orderBy('nom')->get()->unique('nom');



        $recommendedArticles = Article::with('user', 'categories')

                                      ->inRandomOrder()

                                      ->where('statue', 'publié')

                                      ->take(5)

                                      ->get();



        return view('articles.edit', compact('article', 'categories', 'recommendedArticles'));

    }



        public function update(Request $request, Article $article)



        {



            $this->authorize('update', $article);



    



            // Valider uniquement le contenu, car c'est le seul champ modifiable



            $validatedData = $request->validate([



                'contenu' => 'required|string',



            ]);



    



            $article->update([



                'contenu' => $validatedData['contenu'],



            ]);



    



            return redirect()->route('articles.show', $article)->with('success', 'Article mis à jour avec succès !');



        }



    public function destroy(Article $article)

    {

        $this->authorize('delete', $article);



        // Delete image if exists

        if ($article->image) {

            \Storage::disk('public')->delete($article->image);

        }

        

        $article->delete();



        return redirect()->route('home')->with('success', 'Article supprimé avec succès !');

    }

}


