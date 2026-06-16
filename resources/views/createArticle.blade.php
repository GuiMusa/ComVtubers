@extends('layouts.base')

@section('title', 'Créer un nouvel article')
 
@section('content-with-sidebar')
    <!-- Barre latérale gauche -->
    @include('layouts.Lsidebar')
 
    <!-- Contenu principal -->
    <main class="col-md-6">
        <div class="bg-white p-4 rounded-3 shadow-sm">
            <h1>Créer un nouvel article</h1>
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

            <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="titre" class="form-label">Titre de l'article*</label>
                    <input type="text" class="form-control" id="titre" name="titre" value="{{ old('titre') }}" required>
                </div>

                <div class="mb-3">
                    <label for="contenu" class="form-label">Message*</label>
                    <textarea class="form-control" id="contenu" name="contenu" rows="8" required style="resize: none;">{{ old('contenu') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="categorie_id" class="form-label">Catégorie*</label>
                    <select class="form-select" id="categorie_id" name="categorie_id" required>
                        <option selected disabled value="">Choisir une catégorie...</option>
                        @foreach($categories as $categorie)
                            <option value="{{ $categorie->id }}" {{ old('categorie_id') == $categorie->id ? 'selected' : '' }}>{{ $categorie->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="media" class="form-label">Ajouter une image ou une vidéo</label>
                    <input class="form-control" type="file" id="media" name="media" accept="image/*,video/*">
                </div>

                <button type="submit" class="btn btn-primary w-100">Poster l'article</button>
            </form>
        </div>
    </main>
 
    <!-- Barre latérale droite -->
    @include('layouts.Rsidebar')
@endsection