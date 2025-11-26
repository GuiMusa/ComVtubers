<!-- Barre latérale droite -->
<aside class="col-md-3">
    <div class="sidebar-card">
        <h3 class="sidebar-title">
            <i class="bi bi-stars me-2"></i>Articles Recommandés
        </h3>
        
        <div class="recommended-articles">
            @forelse($recommendedArticles as $article)
                <a href="{{ route('articles.show', $article) }}" class="recommended-card">
                    @if($article->image)
                        <div class="recommended-image">
                            <img src="{{ $article->image }}" alt="{{ $article->titre }}">
                        </div>
                    @else
                        <div class="recommended-image recommended-placeholder">
                            <i class="bi bi-image"></i>
                        </div>
                    @endif
                    <div class="recommended-content">
                        <h4 class="recommended-title">{{ Str::limit($article->titre, 40) }}</h4>
                        <p class="recommended-meta">
                            <i class="bi bi-person-circle me-1"></i>{{ $article->user->name ?? 'Anonyme' }}
                        </p>
                    </div>
                </a>
            @empty
                <div class="empty-recommendations">
                    <i class="bi bi-journal-x"></i>
                    <p>Aucun article recommandé pour le moment.</p>
                </div>
            @endforelse
        </div>
    </div>
</aside>
