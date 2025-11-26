<article class="p-4 p-md-5 mb-4 bg-white rounded shadow-sm article-card">
    <header class="pb-3 border-bottom mb-4">
        @if($article->image)
            <div class="article-hero-image mb-4 rounded shadow-sm">
                <a href="{{ route('articles.show', $article) }}">
                    <img src="{{ $article->image }}" alt="{{ $article->titre }}" class="img-fluid w-100 article-cover-image">
                </a>
            </div>
        @endif

        @if($article->categories->isNotEmpty())
            <div class="mb-2">
                @foreach($article->categories as $categorie)
                    <span class="badge rounded-pill bg-dark text-uppercase me-1">{{ $categorie->nom }}</span>
                @endforeach
            </div>
        @endif
        
        <h2 class="h3 fw-bolder mb-2 text-break">
            <a href="{{ route('articles.show', $article) }}" class="text-decoration-none text-dark">{{ $article->titre }}</a>
        </h2>

        <div class="d-flex align-items-center text-muted">
            @if($article->user)
                <div>
                    <small class="fw-bold">Par {{ $article->user->name }}</small> | 
                    <small class="text-secondary">
                        Publié le {{ \Carbon\Carbon::parse($article->date)->isoFormat('LL') }}
                    </small>
                </div>
            @endif
        </div>
    </header>

    <section class="article-body">
        <div>{{ Str::limit(strip_tags($article->contenu), 250) }}</div>
    </section>
    
    <footer class="pt-4 mt-4 border-top">
        <a href="{{ route('articles.show', $article) }}" class="btn-read-more">
            <span>Lire la suite</span>
            <i class="bi bi-arrow-right ms-2"></i>
        </a>
    </footer>
</article>
