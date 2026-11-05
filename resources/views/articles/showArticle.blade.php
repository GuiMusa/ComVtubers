@extends('layouts.base')

@section('title', $article->titre)

@section('content-with-sidebar')
    <!-- Barre latérale gauche -->
    <div class="lg:col-span-3 order-2 lg:order-1">
        @include('layouts.Lsidebar')
    </div>

    <!-- Contenu principal de l'article -->
    <main class="lg:col-span-6 order-1 lg:order-2">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <article class="bg-white p-6 rounded-xl shadow-sm mb-6">
            @auth
                @can('update', $article)
                    <div class="flex justify-end gap-2 mb-4">
                        <a href="{{ route('articles.edit', $article) }}"
                        class="px-3 py-1.5 text-sm border border-amber-500 text-amber-600 rounded-lg hover:bg-amber-50">
                            Modifier
                        </a>
                        <form action="{{ route('articles.destroy', $article) }}" method="POST"
                            onsubmit="return confirm('Supprimer ?')">
                            @csrf @method('DELETE')
                            <button class="px-3 py-1.5 text-sm border border-red-500 text-red-600 rounded-lg hover:bg-red-50">
                                Supprimer
                            </button>
                        </form>
                    </div>
                @endcan
            @endauth

            {{-- Titre et métadonnées --}}
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3">
                {{ $article->titre }}
            </h1>
            
            <div class="flex flex-wrap items-center text-sm text-gray-500 mb-6 gap-2">
                <span>Publié le {{ \Carbon\Carbon::parse($article->date)->format('d/m/Y') }}</span>
                <span>•</span>
                <span>Par <strong class="text-gray-700">{{ $article->user->name ?? 'Auteur inconnu' }}</strong></span>
                @if($article->categorie)
                    <span>•</span>
                    <span class="bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full text-xs font-semibold">
                        {{ $article->categorie->nom }}
                    </span>
                @endif
            </div>

            {{-- Média (Image ou Vidéo) --}}
            @if($article->media)
                <div class="mb-6 rounded-xl overflow-hidden shadow-sm bg-gray-100 flex justify-center">
                    @php
                        $extension = strtolower(pathinfo($article->media, PATHINFO_EXTENSION));
                        $is_video = in_array($extension, ['mp4', 'mov', 'avi']);
                    @endphp

                    @if($is_video)
                        <video controls class="w-full h-auto max-h-[600px] object-contain">
                            <source src="{{ asset('storage/' . $article->media) }}" type="video/{{ $extension }}">
                            Votre navigateur ne supporte pas la lecture de vidéos.
                        </video>
                    @else
                        <img src="{{ asset('storage/' . $article->media) }}" alt="{{ $article->titre }}" class="w-full h-auto object-cover">
                    @endif
                </div>
            @endif

            {{-- Contenu de l'article --}}
            {{-- whitespace-pre-line permet de conserver les retours à la ligne tapés dans le textarea --}}
            <div class="text-gray-700 leading-relaxed whitespace-pre-line text-base md:text-lg">
                {{ $article->contenu }}
            </div>
        </article>

        {{-- Section Commentaires (à décommenter et adapter si tu as le code) --}}
        {{-- <div class="bg-white p-6 rounded-xl shadow-sm mb-6">
            <h2 class="text-xl font-bold mb-4">Commentaires</h2>
            @include('articles.commentaires', ['commentaires' => $article->commentaires])
        </div> --}}
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
