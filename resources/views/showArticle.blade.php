@extends('layouts.base')

@section('title', $article->titre)

@section('content-with-sidebar')
    <!-- Barre latérale gauche -->
    @include('layouts.Lsidebar')

    <!-- Contenu principal de l'article -->
    <main class="col-md-6">
        {{-- Affichage des messages de succès (flash sessions) --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <article class="bg-white p-4 rounded-3 shadow-sm mb-4">
            {{-- Actions réservées à l'auteur de l'article --}}
            @auth
                @if(auth()->id() === $article->user_id)
                    <div class="d-flex justify-content-end gap-2 mb-3">
                        <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-outline-warning btn-sm">
                            Modifier l'article
                        </a>
                        <form action="{{ route('articles.destroy', $article->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article ? Cette action est irréversible.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                Supprimer l'article
                            </button>
                        </form>
                    </div>
                @endif
            @endauth

            {{-- En-tête de l'article (Titre, Catégorie, Date, Auteur) --}}
            <header class="mb-4">
                <h1 class="fw-bold">{{ $article->titre }}</h1>
                <div class="text-muted small d-flex align-items-center gap-2">
                    @if($article->categorie)
                        <span class="badge bg-secondary">{{ $article->categorie->nom }}</span>
                    @endif
                    <span>•</span>
                    <span>Posté le {{ \Carbon\Carbon::parse($article->date)->format('d/m/Y à H:i') }}</span>
                    @if($article->user)
                        <span>•</span>
                        <span>par <strong>{{ $article->user->name }}</strong></span>
                    @endif
                </div>
            </header>

            {{-- Affichage du média : Image ou Vidéo --}}
            @if($article->media)
                <div class="mb-4 text-center">
                    @php
                        $extension = pathinfo($article->media, PATHINFO_EXTENSION);
                        $is_video = in_array(strtolower($extension), ['mp4', 'mov', 'avi']);
                    @endphp

                    @if($is_video)
                        <video controls class="img-fluid rounded shadow-sm w-100">
                            <source src="{{ asset('storage/' . $article->media) }}" type="video/{{ $extension }}">
                            Votre navigateur ne supporte pas la lecture de vidéos.
                        </video>
                    @else
                        <img src="{{ asset('storage/' . $article->media) }}" class="img-fluid rounded shadow-sm" alt="{{ $article->titre }}">
                    @endif
                </div>
            @endif

            {{-- Contenu textuel de l'article --}}
            <div class="article-content fs-5" style="white-space: pre-line;">
                {{ $article->contenu }}
            </div>

            @if($article->favoris)
                <div class="mt-4">
                    <span class="badge bg-warning text-dark">⭐ Favoris</span>
                </div>
            @endif
        </article>

        {{-- SECTION COMMENTAIRES --}}
        <section class="comments-section">
            <h3 class="mb-4">Commentaires ({{ $article->commentaires->count() }})</h3>

            @auth
                {{-- Formulaire pour ajouter un commentaire principal --}}
                <div class="bg-light p-3 rounded-3 mb-4 shadow-sm border">
                    <form action="{{ route('commentaires.store', $article->id) }}" method="POST">
                        @csrf
                        <div class="mb-2">
                            {{-- textarea avec resize:none comme demandé --}}
                            <textarea name="contenu" class="form-control @error('contenu') is-invalid @enderror" rows="3" placeholder="Laissez un commentaire..." style="resize: none;" required></textarea>
                            @error('contenu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Envoyer</button>
                    </form>
                </div>
            @else
                <div class="alert alert-secondary text-center">
                    <a href="{{ route('login') }}">Connectez-vous</a> pour laisser un commentaire.
                </div>
            @endauth

            {{-- Liste des commentaires --}}
            <div class="list-group shadow-sm">
                {{-- 
                    On ne boucle ici que sur les commentaires "parents" (parent_id est nul).
                    Les réponses seront gérées récursivement par le partiel.
                --}}
                @forelse($article->commentaires->where('parent_id', null)->sortByDesc('date') as $commentaire)
                    @include('partials.commentaire', ['commentaire' => $commentaire, 'article' => $article])
                @empty
                    <div class="alert alert-info text-center">
                        Soyez le premier à commenter cet article !
                    </div>
                @endforelse
            </div>
        </section>
    </main>

    {{-- SCRIPTS JAVASCRIPT pour l'interactivité des formulaires --}}
    <script>
        /**
         * Affiche ou masque le formulaire de réponse sous un commentaire.
         */
        function toggleReplyForm(commentId) {
            const form = document.getElementById('reply-form-' + commentId);
            if (form.classList.contains('d-none')) {
                form.classList.remove('d-none');
            } else {
                form.classList.add('d-none');
            }
        }

        /**
         * Bascule entre l'affichage du texte du commentaire et son formulaire de modification.
         */
        function toggleEditForm(commentId) {
            const content = document.getElementById('comment-content-' + commentId);
            const form = document.getElementById('edit-form-' + commentId);
            
            if (form.classList.contains('d-none')) {
                form.classList.remove('d-none'); // On affiche le formulaire
                content.classList.add('d-none'); // On masque le texte original
            } else {
                form.classList.add('d-none');    // On masque le formulaire
                content.classList.remove('d-none'); // On ré-affiche le texte
            }
        }
    </script>

    <!-- Barre latérale droite (Recommandations) -->
    @include('layouts.Rsidebar')
@endsection
