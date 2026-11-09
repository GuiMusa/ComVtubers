{{-- 
    Ce fichier est un "partiel" Blade récursif. 
    Il s'occupe d'afficher UN commentaire et s'appelle lui-même pour afficher ses réponses.
--}}

<div class="mb-3 p-4 rounded-xl border {{ $commentaire->parent_id ? 'bg-gray-50 border-gray-200 ml-4 lg:ml-8' : 'bg-white border-gray-100 shadow-sm' }}">
    <div class="flex flex-col sm:flex-row justify-between mb-2 gap-1">
        <div class="font-bold {{ $commentaire->parent_id ? 'text-gray-600 text-sm' : 'text-blue-600' }}">
            {{ $commentaire->user ? $commentaire->user->name : 'Utilisateur anonyme' }}
            
            {{-- Petit texte pour indiquer à qui on répond dans les fils imbriqués --}}
            @if($commentaire->parent)
                <span class="text-gray-400 font-normal text-xs ml-1">
                    répond à {{ $commentaire->parent->user ? $commentaire->parent->user->name : 'un utilisateur' }}
                </span>
            @endif
        </div>
        
        <div class="flex items-center gap-2 text-xs text-gray-400">
            {{-- Mention "(Modifié)" si la date de mise à jour est différente de la date de création --}}
            @if($commentaire->created_at != $commentaire->updated_at)
                <span>(Modifié)</span>
            @endif
            <span>{{ \Carbon\Carbon::parse($commentaire->date)->format('d/m/Y H:i') }}</span>
        </div>
    </div>
    
    {{-- Affichage du contenu textuel. Il est masqué par JS si on passe en mode édition --}}
    <div id="comment-content-{{ $commentaire->id }}">
        <p class="text-gray-700 break-words whitespace-pre-wrap {{ $commentaire->parent_id ? 'text-sm' : '' }}">{{ $commentaire->contenu }}</p>
    </div>
    
    @auth
        {{-- Formulaire d'édition : Masqué par défaut (classe hidden de Tailwind) --}}
        @if(Auth::id() === $commentaire->user_id)
            <div id="edit-form-{{ $commentaire->id }}" class="mt-3 hidden">
                <form action="{{ route('commentaires.update', $commentaire->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-2">
                        <textarea name="contenu" class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none resize-none" rows="2" required>{{ $commentaire->contenu }}</textarea>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="px-3 py-1.5 bg-green-600 text-white rounded-lg text-xs font-bold hover:bg-green-700 transition-colors">Enregistrer</button>
                        <button type="button" class="px-3 py-1.5 bg-gray-200 text-gray-700 rounded-lg text-xs font-bold hover:bg-gray-300 transition-colors" onclick="toggleEditForm({{ $commentaire->id }})">Annuler</button>
                    </div>
                </form>
            </div>
        @endif

        {{-- Barre d'actions (Répondre, Modifier, Supprimer) --}}
        <div class="flex gap-4 mt-2">
            <button class="text-xs font-bold text-gray-500 hover:text-blue-600 transition-colors" 
                    type="button" 
                    onclick="toggleReplyForm({{ $commentaire->id }})">
                Répondre
            </button>

            @if(Auth::id() === $commentaire->user_id)
                <button class="text-xs font-bold text-amber-500 hover:text-amber-600 transition-colors" 
                        type="button" 
                        onclick="toggleEditForm({{ $commentaire->id }})">
                    Modifier
                </button>

                <form action="{{ route('commentaires.destroy', $commentaire->id) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ? Cela supprimera également toutes les réponses associées.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-xs font-bold text-red-500 hover:text-red-600 transition-colors">
                        Supprimer
                    </button>
                </form>
            @endif
        </div>

        {{-- Formulaire de réponse : Masqué par défaut --}}
        <div id="reply-form-{{ $commentaire->id }}" class="mt-3 hidden">
            <form action="{{ route('commentaires.store', $article->id) }}" method="POST">
                @csrf
                <input type="hidden" name="parent_id" value="{{ $commentaire->id }}">
                <div class="mb-2">
                    <textarea name="contenu" class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none resize-none" rows="2" placeholder="Votre réponse..." required></textarea>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="px-3 py-1.5 bg-blue-600 text-white rounded-lg text-xs font-bold hover:bg-blue-700 transition-colors">Envoyer</button>
                    <button type="button" class="px-3 py-1.5 bg-gray-200 text-gray-700 rounded-lg text-xs font-bold hover:bg-gray-300 transition-colors" onclick="toggleReplyForm({{ $commentaire->id }})">Annuler</button>
                </div>
            </form>
        </div>
    @endauth

    {{-- Réponses imbriquées --}}
    @if($commentaire->reponses->count() > 0)
        <div class="mt-3 border-l-2 border-gray-200 pl-2">
            @foreach($commentaire->reponses as $reponse)
                @include('partials.commentaire', ['commentaire' => $reponse, 'article' => $article])
            @endforeach
        </div>
    @endif
</div>