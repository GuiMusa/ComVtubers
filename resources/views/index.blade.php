@extends('layouts.base')

@section('title', 'Accueil - Les derniers articles')

@section('content-with-sidebar')
    @include('layouts.Lsidebar')

    <main class="col-md-6 article-main-content">
        @auth
            <div class="mb-4 text-center">
                <a href="{{ route('articles.create') }}" class="btn btn-primary btn-lg px-5 py-3 shadow">
                    <i class="bi bi-plus-circle me-2"></i> Créer un article
                </a>
            </div>
        @endauth
        <div id="articles-container">
            @forelse ($articles as $article)
                @include('partials._article-card', ['article' => $article])
            @empty
                <div class="p-4 p-md-5 rounded text-center empty-state">
                    <h1 class="display-5 fw-bolder">Bienvenue !</h1>
                    <p class="lead">Aucun article n'a été publié pour le moment.</p>
                    <p>Revenez bientôt pour découvrir nos contenus.</p>
                    @auth
                        <a href="{{ route('articles.create') }}" class="btn btn-primary mt-3">Écrire le premier article</a>
                    @endauth
                </div>
            @endforelse
        </div>

        @if ($articles->hasMorePages())
            <div class="d-flex justify-content-center mt-4">
                <button id="load-more" class="btn btn-lg btn-outline-primary">Charger plus d'articles</button>
            </div>
        @endif
    </main>

    @include('layouts.Rsidebar')
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const loadMoreButton = document.getElementById('load-more');
    if (!loadMoreButton) {
        return;
    }

    let nextPageUrl = '{{ $articles->nextPageUrl() }}';

    loadMoreButton.addEventListener('click', function () {
        if (!nextPageUrl) {
            return;
        }

        loadMoreButton.disabled = true;
        loadMoreButton.textContent = 'Chargement...';

        fetch(nextPageUrl, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.articles_html) {
                const articlesContainer = document.getElementById('articles-container');
                articlesContainer.insertAdjacentHTML('beforeend', data.articles_html);
            }
            
            nextPageUrl = data.next_page_url;

            if (nextPageUrl) {
                loadMoreButton.disabled = false;
                loadMoreButton.textContent = "Charger plus d'articles";
            } else {
                loadMoreButton.style.display = 'none';
            }
        })
        .catch(error => {
            console.error('Erreur lors du chargement des articles:', error);
            loadMoreButton.disabled = false;
            loadMoreButton.textContent = "Erreur. Réessayer";
        });
    });
});
</script>
@endpush