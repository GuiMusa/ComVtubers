<!-- Barre latérale droite -->
<aside class="col-md-3">
    <div class="card">
        <div class="card-header">
            Articles Recommandés
        </div>
        <div class="card-body">
            @forelse($recommendedArticles as $article)
                <div class="mb-3">
                    @if($article->media)
                        <a href="{{ route('articles.show', $article->id) }}">
                            @php
                                $extension = pathinfo($article->media, PATHINFO_EXTENSION);
                                $is_video = in_array(strtolower($extension), ['mp4', 'mov', 'avi']);
                            @endphp
                            @if($is_video)
                                <video class="img-fluid rounded mb-2 w-100">
                                    <source src="{{ asset('storage/' . $article->media) }}">
                                </video>
                            @else
                                <img src="{{ asset('storage/' . $article->media) }}" class="img-fluid rounded mb-2" alt="Image pour {{ $article->titre }}">
                            @endif
                        </a>
                    @endif
                    <h6 class="card-title mb-1">
                        <a href="{{ route('articles.show', $article->id) }}" class="text-decoration-none text-dark">
                            {{ $article->titre }}
                        </a>
                    </h6>
                    <p class="card-text">
                        <small class="text-muted">
                            Publié le {{ \Carbon\Carbon::parse($article->date)->format('d/m/Y') }}
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