<aside class="col-md-3">
    <div class="sidebar-card">
        <h3 class="sidebar-title">
            <i class="bi bi-journal-text me-2"></i>Navigation
        </h3>
        
        <!-- Mes articles -->
        <div class="sidebar-section">
            <button class="sidebar-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#mesArticlesCollapse" aria-expanded="false">
                <span><i class="bi bi-file-earmark-text me-2"></i>Mes articles</span>
                <i class="bi bi-chevron-down toggle-icon"></i>
            </button>
            <div class="collapse" id="mesArticlesCollapse">
                <ul class="sidebar-list">
                    @auth
                        @forelse($userArticles as $article)
                            <li><a href="{{ route('articles.show', $article) }}">{{ Str::limit($article->titre, 30) }}</a></li>
                        @empty
                            <li class="text-muted">Aucun article</li>
                        @endforelse
                    @else
                        <li class="text-muted">Connectez-vous pour voir vos articles</li>
                    @endauth
                </ul>
            </div>
        </div>

        <!-- Articles Favoris -->
        <div class="sidebar-section">
            <button class="sidebar-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#favorisCollapse" aria-expanded="false">
                <span><i class="bi bi-heart me-2"></i>Articles Favoris</span>
                <i class="bi bi-chevron-down toggle-icon"></i>
            </button>
            <div class="collapse" id="favorisCollapse">
                <ul class="sidebar-list">
                    @auth
                        @forelse($favoriteArticles as $article)
                            <li><a href="{{ route('articles.show', $article) }}">{{ Str::limit($article->titre, 30) }}</a></li>
                        @empty
                            <li class="text-muted">Aucun favori</li>
                        @endforelse
                    @else
                        <li class="text-muted">Connectez-vous pour voir vos favoris</li>
                    @endauth
                </ul>
            </div>
        </div>

        <!-- Derniers vus -->
        <div class="sidebar-section">
            <button class="sidebar-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#derniersVusCollapse" aria-expanded="false">
                <span><i class="bi bi-clock-history me-2"></i>Derniers vus</span>
                <i class="bi bi-chevron-down toggle-icon"></i>
            </button>
            <div class="collapse" id="derniersVusCollapse">
                <ul class="sidebar-list">
                    @auth
                        @forelse($lastViewedArticles as $article)
                            <li><a href="{{ route('articles.show', $article) }}">{{ Str::limit($article->titre, 30) }}</a></li>
                        @empty
                            <li class="text-muted">Aucun article récemment vu</li>
                        @endforelse
                    @else
                        <li class="text-muted">Connectez-vous pour voir votre historique</li>
                    @endauth
                </ul>
            </div>
        </div>
    </div>
</aside>
