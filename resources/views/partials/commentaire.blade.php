{{-- 
    Ce fichier est un "partiel" Blade récursif. 
    Il s'occupe d'afficher UN commentaire et s'appelle lui-même pour afficher ses réponses.
--}}

<div class="list-group-item border-0 mb-2 rounded-3 shadow-sm p-3 {{ $commentaire->parent_id ? 'bg-light ms-4' : 'bg-white' }}">
    <div class="d-flex justify-content-between mb-2">
        <div class="fw-bold {{ $commentaire->parent_id ? 'text-secondary small' : 'text-primary' }}">
            {{ $commentaire->user ? $commentaire->user->name : 'Utilisateur anonyme' }}
            
            {{-- Petit texte pour indiquer à qui on répond dans les fils imbriqués --}}
            @if($commentaire->parent)
                <span class="text-muted fw-normal" style="font-size: 0.8rem;">
                    répond à {{ $commentaire->parent->user ? $commentaire->parent->user->name : 'un utilisateur' }}
                </span>
            @endif
        </div>
        
        <div class="d-flex align-items-center gap-2">
            {{-- Mention "(Modifié)" si la date de mise à jour est différente de la date de création --}}
            @if($commentaire->created_at != $commentaire->updated_at)
                <small class="text-muted" style="font-size: 0.7rem;">(Modifié)</small>
            @endif
            <small class="text-muted" style="font-size: {{ $commentaire->parent_id ? '0.75rem' : '0.85rem' }};">
                {{ \Carbon\Carbon::parse($commentaire->date)->format('d/m/Y H:i') }}
            </small>
        </div>
    </div>
    
    {{-- Affichage du contenu textuel. Il est masqué par JS si on passe en mode édition --}}
    <div id="comment-content-{{ $commentaire->id }}">
        <p class="mb-2 {{ $commentaire->parent_id ? 'small' : '' }}">{{ $commentaire->contenu }}</p>
    </div>

    @auth
        {{-- Formulaire d'édition : Masqué par défaut (classe d-none de Bootstrap) --}}
        @if(Auth::id() === $commentaire->user_id)
            <div id="edit-form-{{ $commentaire->id }}" class="mt-2 mb-2 d-none">
                <form action="{{ route('commentaires.update', $commentaire->id) }}" method="POST">
                    @csrf
                    @method('PATCH') {{-- Utilisation de PATCH pour la mise à jour partielle --}}
                    <div class="mb-2">
                        <textarea name="contenu" class="form-control form-control-sm" rows="2" style="resize: none;" required>{{ $commentaire->contenu }}</textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success btn-sm" style="font-size: 0.75rem;">Enregistrer</button>
                        <button type="button" class="btn btn-light btn-sm border" onclick="toggleEditForm({{ $commentaire->id }})" style="font-size: 0.75rem;">Annuler</button>
                    </div>
                </form>
            </div>
        @endif

        {{-- Barre d'actions (Répondre, Modifier, Supprimer) --}}
        <div class="d-flex gap-3 mb-1">
            <button class="btn btn-link btn-sm p-0 text-decoration-none text-muted fw-bold" 
                    type="button" 
                    onclick="toggleReplyForm({{ $commentaire->id }})"
                    style="font-size: 0.8rem;">
                Répondre
            </button>

            @if(Auth::id() === $commentaire->user_id)
                <button class="btn btn-link btn-sm p-0 text-decoration-none text-warning fw-bold" 
                        type="button" 
                        onclick="toggleEditForm({{ $commentaire->id }})"
                        style="font-size: 0.8rem;">
                    Modifier
                </button>

                {{-- Formulaire de suppression : utilisation de confirm() en JS pour la sécurité --}}
                <form action="{{ route('commentaires.destroy', $commentaire->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ? Cela supprimera également toutes les réponses associées.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-link btn-sm p-0 text-decoration-none text-danger fw-bold" style="font-size: 0.8rem;">
                        Supprimer
                    </button>
                </form>
            @endif
        </div>

        {{-- Formulaire de réponse : Masqué par défaut --}}
        <div id="reply-form-{{ $commentaire->id }}" class="mt-2 mb-2 d-none">
            <form action="{{ route('commentaires.store', $article->id) }}" method="POST">
                @csrf
                {{-- Champ caché indispensable pour lier la réponse au commentaire parent --}}
                <input type="hidden" name="parent_id" value="{{ $commentaire->id }}">
                <div class="mb-2">
                    <textarea name="contenu" class="form-control form-control-sm" rows="2" placeholder="Votre réponse..." style="resize: none;" required></textarea>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-sm" style="font-size: 0.75rem;">Envoyer</button>
                    <button type="button" class="btn btn-light btn-sm border" onclick="toggleReplyForm({{ $commentaire->id }})" style="font-size: 0.75rem;">Annuler</button>
                </div>
            </form>
        </div>
    @endauth

    {{-- 
        C'EST ICI QUE LA MAGIE OPÈRE :
        Si le commentaire a des réponses, on ré-inclut ce même fichier pour chaque réponse.
    --}}
    @if($commentaire->reponses->count() > 0)
        <div class="mt-2 border-start ps-1">
            @foreach($commentaire->reponses as $reponse)
                @include('partials.commentaire', ['commentaire' => $reponse, 'article' => $article])
            @endforeach
        </div>
    @endif
</div>
