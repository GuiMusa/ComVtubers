@extends('layouts.base')

@section('title', 'Modifier l\'article')
 
@section('content-with-sidebar')
    <!-- Barre latérale gauche -->
    @include('layouts.Lsidebar')
 
    <!-- Contenu principal -->
    <main class="col-md-6">
        <div class="bg-white p-4 rounded-3 shadow-sm">
            <h1>Modifier l'article</h1>
            <hr>

            {{-- Affichage des erreurs de validation --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('articles.update', $article) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label class="form-label">Titre de l'article</label>
                    <p class="form-control-static">{{ $article->titre }}</p>
                    <input type="hidden" name="titre" value="{{ $article->titre }}"> {{-- Keep original title value for validation --}}
                </div>

                <div class="mb-3">
                    <label for="contenu" class="form-label">Message*</label>
                    <textarea class="form-control no-resize" id="contenu" name="contenu" rows="8" required>{{ old('contenu', $article->contenu) }}</textarea>
                </div>

                {{-- Catégories - Désactivées pour édition de message uniquement
                <div class="mb-3">
                    <label for="categories" class="form-label">Catégories</label>
                    <select class="form-select" id="categories" name="categories[]" multiple>
                        @foreach($categories as $categorie)
                            <option value="{{ $categorie->id }}" 
                                {{ (collect(old('categories', $article->categories->pluck('id')))->contains($categorie->id)) ? 'selected' : '' }}>
                                {{ $categorie->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
                --}}

                {{-- Image - Désactivée pour édition de message uniquement
                <div class="mb-4">
                    <label for="image" class="form-label">Image actuelle</label>
                    @if($article->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $article->image) }}" alt="Image actuelle" style="max-width: 200px; height: auto;">
                        </div>
                    @endif
                    <input class="form-control" type="file" id="image" name="image" accept="image/*">
                    <div class="form-text">Laisser vide pour conserver l\'image actuelle.</div>
                </div>
                --}}

                <button type="submit" class="btn btn-primary w-100">Mettre à jour l'article</button>
                <a href="{{ route('articles.show', $article) }}" class="btn btn-secondary w-100 mt-2">Annuler</a>
            </form>
        </div>
    </main>
 
    <!-- Barre latérale droite -->
    @include('layouts.Rsidebar')
@endsection
