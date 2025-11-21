<aside class="col-md-3">
    <div class="sidebar-block">
        <h3 class="fs-5 mb-3">Articles récemment visité</h3>
        <ul class="nav flex-column nav-pills">
            <li class="nav-item">
                {{-- Utilisation de d-flex pour aligner le texte et la flèche --}}
                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#mesArticlesCollapse" role="button" aria-expanded="false" aria-controls="mesArticlesCollapse">
                    <span>Mes articles</span>
                    {{-- La flèche qui va pivoter --}}
                    <span class="arrow-indicator"></span>
                </a>
                <div class="collapse" id="mesArticlesCollapse">
                    <ul class="nav flex-column ps-3">
                        @auth
                            @forelse($userArticles as $article)
                                <li class="nav-item"><a class="nav-link py-1" href="#">{{ $article->titre }}</a></li>
                            @empty
                                <li class="nav-item"><span class="nav-link text-muted py-1">Aucun article</span></li>
                            @endforelse
                        @else
                            <li class="nav-item"><span class="nav-link text-muted py-1">Connectez-vous pour voir vos articles</span></li>
                        @endauth
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#favorisCollapse" role="button" aria-expanded="false" aria-controls="favorisCollapse">
                    <span>Articles Favoris</span>
                    <span class="arrow-indicator"></span>
                </a>
                <div class="collapse" id="favorisCollapse">
                    <ul class="nav flex-column ps-3">
                        @auth
                            @forelse($favoriteArticles as $article)
                                <li class="nav-item"><a class="nav-link py-1" href="#">{{ $article->titre }}</a></li>
                            @empty
                                <li class="nav-item"><span class="nav-link text-muted py-1">Aucun favori</span></li>
                            @endforelse
                        @else
                            <li class="nav-item"><span class="nav-link text-muted py-1">Connectez-vous pour voir vos favoris</span></li>
                        @endauth
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#derniersVusCollapse" role="button" aria-expanded="false" aria-controls="derniersVusCollapse">
                    <span>Derniers vus</span>
                    <span class="arrow-indicator"></span>
                </a>
                <div class="collapse" id="derniersVusCollapse">
                    <ul class="nav flex-column ps-3">
                        @auth
                            @forelse($lastViewedArticles as $article)
                                <li class="nav-item"><a class="nav-link py-1" href="{{ route('articles.show', $article) }}">{{ $article->titre }}</a></li>
                            @empty
                                <li class="nav-item"><span class="nav-link text-muted py-1">Aucun article récemment vu</span></li>
                            @endforelse
                        @else
                            <li class="nav-item"><span class="nav-link text-muted py-1">Connectez-vous pour voir votre historique</span></li>
                        @endauth
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</aside>