<!-- Barre latérale droite - Don Juan -->
<aside class="col-md-3">
    <div class="sidebar-block don-juan-sidebar">
        <h3 class="sidebar-title">Mes Confidences</h3>
        <div class="diary-card-container">
            @forelse($recommendedArticles as $article)
                <a href="{{ route('articles.show', $article) }}" class="diary-card">
                    @if($article->image)
                        <img src="{{ $article->image }}" class="diary-image" alt="">
                    @endif
                    <h4 class="diary-title">{{ $article->titre }}</h4>
                    <p class="diary-meta">
                        Par {{ $article->user->name ?? 'un secret' }}
                    </p>
                </a>
            @empty
                <div class="text-center text-muted">
                    Aucun secret à partager pour le moment.
                </div>
            @endforelse
        </div>
    </div>
</aside>