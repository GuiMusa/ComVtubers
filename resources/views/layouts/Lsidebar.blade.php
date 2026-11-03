<aside class="col-md-3">
    <div class="bg-white rounded-3 shadow-sm p-3">
        <h3 class="fs-5 mb-3">Articles récemment visité</h3>
        <ul class="nav flex-column nav-pills">

            {{-- ============================================ --}}
            {{-- BLOC 1 : MES ARTICLES --}}
            {{-- ============================================ --}}
            <li class="nav-item">
                <a class="nav-link text-dark d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#mesArticlesCollapse" role="button" aria-expanded="false" aria-controls="mesArticlesCollapse">
                    <span>Mes articles</span>
                    <span class="arrow-indicator"></span>
                </a>
                <div class="collapse" id="mesArticlesCollapse">
                    <ul class="nav flex-column ps-3">
                        @auth
                            @forelse($userArticles as $article)
                                <li class="nav-item">
                                    <a class="nav-link text-secondary py-1" href="{{ route('articles.show', $article->id) }}">
                                        {{ $article->titre }}
                                    </a>
                                </li>
                            @empty
                                <li class="nav-item"><span class="nav-link text-muted py-1">Aucun article</span></li>
                            @endforelse
                        @else
                            <li class="nav-item"><span class="nav-link text-muted py-1">Connectez-vous pour voir vos articles</span></li>
                        @endauth
                    </ul>
                </div>
            </li>

            {{-- ============================================ --}}
            {{-- BLOC 2 : DERNIERS VUS --}}
            {{-- (affiche les derniers articles publiés du site) --}}
            {{-- ============================================ --}}
            <li class="nav-item">
                <a class="nav-link text-dark d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#derniersVusCollapse" role="button" aria-expanded="false" aria-controls="derniersVusCollapse">
                    <span>Derniers vus</span>
                    <span class="arrow-indicator"></span>
                </a>
                <div class="collapse" id="derniersVusCollapse">
                    <ul class="nav flex-column ps-3">
                        @forelse($latestArticles as $article)
                            <li class="nav-item">
                                <a class="nav-link text-secondary py-1" href="{{ route('articles.show', $article->id) }}">
                                    {{ $article->titre }}
                                </a>
                            </li>
                        @empty
                            <li class="nav-item"><span class="nav-link text-muted py-1">Aucun article pour le moment</span></li>
                        @endforelse
                    </ul>
                </div>
            </li>

        </ul>
    </div>
</aside>