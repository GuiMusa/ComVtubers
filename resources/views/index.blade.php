@extends('layouts.app')

@section('title', 'Accueil du Forum')

@section('content')
<div class="container mt-4">
    <h1>Les 10 derniers articles</h1>
    
    <!-- Contrôle de pagination en haut -->
    <div class="d-flex justify-content-center mb-4">
        {{ $articles->links() }}
    </div>

    <!-- Liste des articles -->
    <div class="row">
        @forelse($articles as $article)
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $article->titre }}</h5>
                        <p class="card-text">
                            <small class="text-muted">
                                Publié le {{ \Carbon\Carbon::parse($article->date)->format('d/m/Y à H:i') }}
                            </small>
                        </p>
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
        {{ $articles->links() }}
    </div>
</div>
@endsection