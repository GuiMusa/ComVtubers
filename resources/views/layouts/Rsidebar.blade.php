<!-- Barre latérale droite -->
<aside class="col-md-3">
    <div class="card">
        <div class="card-header">
            Articles Recommandés
        </div>
        <div class="card-body">
            @forelse($recommendedArticles as $article)
                <div class="mb-3">
                    @if($article->image)
                        <img src="{{ $article->image }}" class="img-fluid rounded mb-2" alt="Image pour {{ $article->titre }}">
                    @endif
                    <h6 class="card-title mb-1">{{ $article->titre }}</h6>
                    <p class="card-text">
                        <small class="text-muted">
                            Publié le {{ \Carbon\Carbon::parse($article->date)->format('d/m/Y') }}
                            @if($article->user)
                                par <strong>{{ $article->user->name }}</strong>
                            @endif
                        </small>
                    </p>
                    @if($article->categories->isNotEmpty())
                        <div class="mb-2">
                            @foreach($article->categories as $categorie)
                                <span class="badge bg-secondary">{{ $categorie->nom }}</span>
                            @endforeach
                        </div>
                    @endif
                    @if($loop->last)
                    @else
                        <hr>
                    @endif
                </div>
            @empty
                <div class="alert alert-info">
                    Aucun article à recommander.
                </div>
            @endforelse
        </div>
    </div>
</aside>