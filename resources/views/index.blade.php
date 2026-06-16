@extends('layouts.base')

@section('title', 'Accueil du Forum')
@section('content-with-sidebar')
    <!-- Barre latérale -->
    @include('layouts.Lsidebar')

    <!-- Contenu principal -->
    <main class="col-md-6">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="mb-0">Les articles récents</h1>
            @auth
                <a href="{{ route('articles.create') }}" class="btn btn-primary">Créer un article</a>
            @endauth
        </div>
        
        <!-- Contrôle de pagination en haut -->
        <div class="d-flex justify-content-center mb-4">
            {{ $articles->links('pagination::bootstrap-5') }}
        </div>
    
        <!-- Liste des articles -->
        <div class="row">
            @forelse($articles as $article)
                <div class="col-md-6 mb-4">
                    <div class="card">
                        @if($article->image)
                            <img src="{{ $article->image }}" class="card-img-top" alt="Image pour {{ $article->titre }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $article->titre }}</h5>
                            <p class="card-text">
                                <small class="text-muted">
                                    Publié le {{ \Carbon\Carbon::parse($article->date)->format('d/m/Y à H:i') }}
                                    @if($article->user)
                                        par <strong>{{ $article->user->name }}</strong>
                                    @endif
                                </small>
                            </p>
    
                            @if($article->categorie)
                                <div class="mb-2">
                                    <span class="badge bg-secondary">{{ $article->categorie->nom }}</span>
                                </div>
                            @endif
    
                            @if($article->favoris)
                                <span class="badge bg-warning">⭐ Favoris</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        Aucun article disponible pour le moment.
                    </div>
                </div>
            @endforelse
        </div>
    
        <!-- Contrôle de pagination en bas -->
        <div class="d-flex justify-content-center mt-4">
            {{ $articles->links('pagination::bootstrap-5') }}
        </div>
    </main>

    <!-- Barre latérale droite -->
    @include('layouts.Rsidebar')
@endsection