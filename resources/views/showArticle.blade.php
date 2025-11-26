@extends('layouts.base')

@section('title', $article->titre)
@section('content-with-sidebar')
    <!-- Barre latérale -->
    @include('layouts.Lsidebar')

    <!-- Contenu principal -->
    <main class="col-md-6">
        <!-- Bouton retour -->
        <div class="mb-4">
            <a href="{{ route('home') }}" class="btn-back">
                <i class="bi bi-arrow-left me-2"></i>
                <span>Retour aux articles</span>
            </a>
        </div>

        <!-- Article complet -->
        <article class="card mb-4">
            @if($article->image)
                <img src="{{ $article->image }}" class="card-img-top" alt="Image pour {{ $article->titre }}">
            @endif
            
            <div class="card-body">
                <h1 class="card-title">{{ $article->titre }}</h1>
                
                <div class="d-flex justify-content-end gap-2 mb-3">
                    @can('update', $article)
                        <a href="{{ route('articles.edit', $article) }}" class="btn-edit-article">
                            <i class="bi bi-pencil me-2"></i>
                            <span>Modifier</span>
                        </a>
                    @endcan
                    @can('delete', $article)
                        <form action="{{ route('articles.destroy', $article) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete-article" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?');">
                                <i class="bi bi-trash me-2"></i>
                                <span>Supprimer</span>
                            </button>
                        </form>
                    @endcan
                </div>
                
                <p class="text-muted mb-3">
                    <small>
                        Publié le {{ \Carbon\Carbon::parse($article->date)->format('d/m/Y à H:i') }}
                        @if($article->user)
                            par <strong>{{ $article->user->name }}</strong>
                        @endif
                    </small>
                </p>

                @if($article->categories->isNotEmpty())
                    <div class="mb-3">
                        @foreach($article->categories as $categorie)
                            <span class="badge bg-secondary">{{ $categorie->nom }}</span>
                        @endforeach
                    </div>
                @endif

                @if($article->favoris)
                    <span class="badge bg-warning mb-3">⭐ Favoris</span>
                @endif

                <div class="article-content">
                    {!! nl2br(e($article->contenu)) !!}
                </div>
            </div>
        </article>

        <!-- Section des commentaires -->
        <div class="card">
            <div class="card-header bg-light">
                <h3 class="mb-0">
                    Commentaires 
                    <span class="badge bg-primary">{{ $article->commentaires->count() }}</span>
                </h3>
            </div>
            
            <div class="card-body">
                <!-- Message de succès -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if($article->commentaires->isEmpty())
                    <p class="text-muted text-center py-4">
                        <i class="bi bi-chat-left-text fs-1 d-block mb-2"></i>
                        Aucun commentaire pour le moment. Soyez le premier à commenter !
                    </p>
                @else
                    <div class="comments-list mt-4">
                        @foreach($article->commentaires as $commentaire)
                            <div class="comment mb-4 p-3 bg-white rounded shadow-sm">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" 
                                             style="width: 45px; height: 45px; font-size: 1.3rem;">
                                            {{ strtoupper(substr($commentaire->user->name ?? 'U', 0, 1)) }}
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-1">
                                                {{ $commentaire->user->name ?? 'Utilisateur anonyme' }}
                                                <small class="text-muted ms-2">{{ \Carbon\Carbon::parse($commentaire->date)->diffForHumans() }}</small>
                                            </h6>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-light dropdown-toggle" type="button" 
                                                        id="commentActions{{ $commentaire->id }}" data-bs-toggle="dropdown" 
                                                        aria-expanded="false">
                                                    <i class="bi bi-three-dots"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="commentActions{{ $commentaire->id }}">
                                                    <li>
                                                        <!-- Bouton pour répondre -->
                                                        @auth
                                                            <a class="dropdown-item" href="#" 
                                                                onclick="event.preventDefault(); toggleReplyForm({{ $commentaire->id }})">
                                                                <i class="bi bi-reply me-2"></i> Répondre
                                                            </a>
                                                        @endauth
                                                    </li>
                                                    <li>
                                                        <!-- Bouton pour modifier -->
                                                        @can('update', $commentaire)
                                                            <a class="dropdown-item" href="#" 
                                                                onclick="event.preventDefault(); toggleEditForm({{ $commentaire->id }})">
                                                                <i class="bi bi-pencil me-2"></i> Modifier
                                                            </a>
                                                        @endcan
                                                    </li>
                                                    <li>
                                                        <!-- Bouton pour supprimer -->
                                                        @can('delete', $commentaire)
                                                            <form action="{{ route('commentaires.destroy', $commentaire) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item text-danger" 
                                                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?');">
                                                                    <i class="bi bi-trash me-2"></i> Supprimer
                                                                </button>
                                                            </form>
                                                        @endcan
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        
                                        <div id="comment-content-{{ $commentaire->id }}">
                                            <p class="mb-2 mt-2">{{ $commentaire->contenu }}</p>
                                        </div>
                                        
                                        <div id="comment-edit-form-{{ $commentaire->id }}" style="display: none;">
                                            <form action="{{ route('commentaires.update', $commentaire) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div class="mb-2">
                                                    <textarea 
                                                        name="commentaire" 
                                                        class="form-control form-control-sm no-resize" 
                                                        rows="3" 
                                                        required
                                                    >{{ old('commentaire', $commentaire->contenu) }}</textarea>
                                                </div>
                                                <div class="d-flex gap-2">
                                                    <button type="submit" class="btn btn-sm btn-success">
                                                        <i class="bi bi-check-circle"></i> Enregistrer
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-secondary" 
                                                            onclick="toggleEditForm({{ $commentaire->id }})">
                                                        Annuler
                                                    </button>
                                                </div>
                                            </form>
                                        </div>

                                        <!-- Affichage des réponses (mentions) -->
                                        @if($commentaire->mentions->isNotEmpty())
                                            <div class="mentions-list mt-3 ps-4">
                                                @foreach($commentaire->mentions as $mention)
                                                    <div class="mention p-3 mb-2 bg-light rounded shadow-sm">
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <strong class="text-primary">
                                                                <i class="bi bi-arrow-return-right"></i> Réponse de {{ $mention->user->name ?? 'Utilisateur anonyme' }}
                                                            </strong>
                                                            <small class="text-muted">
                                                                {{ \Carbon\Carbon::parse($mention->date)->diffForHumans() }}
                                                            </small>
                                                            <div class="dropdown">
                                                                <button class="btn btn-sm btn-light dropdown-toggle" type="button" 
                                                                        id="mentionActions{{ $mention->id }}" data-bs-toggle="dropdown" 
                                                                        aria-expanded="false">
                                                                    <i class="bi bi-three-dots"></i>
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="mentionActions{{ $mention->id }}">
                                                                    <li>
                                                                        <!-- Bouton pour répondre à une mention (non implémenté ici, redirige vers l'article) -->
                                                                        @auth
                                                                            <a class="dropdown-item" href="#" 
                                                                               onclick="event.preventDefault(); toggleReplyForm({{ $commentaire->id }});">
                                                                                <i class="bi bi-reply me-2"></i> Répondre
                                                                            </a>
                                                                        @endauth
                                                                    </li>
                                                                    <li>
                                                                        <!-- Bouton pour modifier une mention -->
                                                                        @can('update', $mention)
                                                                            <a class="dropdown-item" href="#" 
                                                                                onclick="event.preventDefault(); toggleEditMentionForm({{ $mention->id }})">
                                                                                <i class="bi bi-pencil me-2"></i> Modifier
                                                                            </a>
                                                                        @endcan
                                                                    </li>
                                                                    <li>
                                                                        <!-- Bouton pour supprimer une mention -->
                                                                        @can('delete', $mention)
                                                                            <form action="{{ route('mentions.destroy', $mention) }}" method="POST" class="d-inline">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit" class="dropdown-item text-danger" 
                                                                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette réponse ?');">
                                                                                    <i class="bi bi-trash me-2"></i> Supprimer
                                                                                </button>
                                                                            </form>
                                                                        @endcan
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        
                                                        <div id="mention-content-{{ $mention->id }}">
                                                            <p class="mb-0">{{ $mention->contenu }}</p>
                                                        </div>
                                                        
                                                        <div id="mention-edit-form-{{ $mention->id }}" style="display: none;">
                                                            <form action="{{ route('mentions.update', $mention) }}" method="POST">
                                                                @csrf
                                                                @method('PATCH')
                                                                <div class="mb-2">
                                                                    <textarea 
                                                                        name="reponse" 
                                                                        class="form-control form-control-sm no-resize" 
                                                                        rows="2" 
                                                                        required
                                                                    >{{ old('reponse', $mention->contenu) }}</textarea>
                                                                </div>
                                                                <div class="d-flex gap-2">
                                                                    <button type="submit" class="btn btn-sm btn-success">
                                                                        <i class="bi bi-check-circle"></i> Enregistrer
                                                                    </button>
                                                                    <button type="button" class="btn btn-sm btn-secondary" 
                                                                            onclick="toggleEditMentionForm({{ $mention->id }})">
                                                                        Annuler
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif

                                        <!-- Formulaire de réponse (caché par défaut) -->
                                        @auth
                                            <div id="reply-form-{{ $commentaire->id }}" class="reply-form mt-3" style="display: none;">
                                                <form action="{{ route('mentions.store', $commentaire) }}" method="POST">
                                                    @csrf
                                                                                                    <div class="mb-2">
                                                                                                        <textarea 
                                                                                                            name="reponse" 
                                                                                                            class="form-control form-control-sm no-resize" 
                                                                                                            rows="2" 
                                                                                                            placeholder="Écrivez votre réponse..."
                                                                                                            required
                                                                                                        ></textarea>
                                                                                                    </div>                                                    <div class="d-flex gap-2">
                                                        <button type="submit" class="btn btn-sm btn-primary">
                                                            <i class="bi bi-send"></i> Envoyer
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-secondary" 
                                                                onclick="toggleReplyForm({{ $commentaire->id }})">
                                                            Annuler
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Formulaire d'ajout de commentaire -->
                @auth
                    <div class="card mt-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Ajouter un commentaire</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('commentaires.store', $article) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <textarea 
                                        name="commentaire" 
                                        class="form-control @error('commentaire') is-invalid @enderror no-resize" 
                                        rows="3" 
                                        placeholder="Écrivez votre commentaire ici..."
                                        required
                                    ></textarea>
                                    @error('commentaire')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-send"></i> Publier le commentaire
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <hr class="my-4">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        Vous devez être <a href="{{ route('login') }}">connecté</a> pour ajouter un commentaire.
                    </div>
                @endauth
            </div>
        </div>
    </main>

    <!-- Barre latérale droite -->
    @include('layouts.Rsidebar')
@endsection

<style>
    .article-content {
        font-size: 1.1rem;
        line-height: 1.8;
    }
    
    .reply-form {
        animation: slideDown 0.3s ease-in-out;
    }

</style>

<script>
    function toggleReplyForm(commentId) {
        const form = document.getElementById('reply-form-' + commentId);
        if (form.style.display === 'none' || form.style.display === '') {
            form.style.display = 'block';
        } else {
            form.style.display = 'none';
        }
    }

    function toggleEditForm(commentId) {
        const content = document.getElementById('comment-content-' + commentId);
        const editForm = document.getElementById('comment-edit-form-' + commentId);

        if (content.style.display === 'none') {
            content.style.display = 'block';
            editForm.style.display = 'none';
        } else {
            content.style.display = 'none';
            editForm.style.display = 'block';
        }
    }

    function toggleEditMentionForm(mentionId) {
        const content = document.getElementById('mention-content-' + mentionId);
        const editForm = document.getElementById('mention-edit-form-' + mentionId);

        if (content.style.display === 'none') {
            content.style.display = 'block';
            editForm.style.display = 'none';
        } else {
            content.style.display = 'none';
            editForm.style.display = 'block';
        }
    }
</script>