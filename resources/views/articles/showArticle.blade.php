@extends('layouts.base')

@section('title', $article->titre)

@section('content-with-sidebar')
    <!-- Barre latérale gauche -->
    @include('layouts.Lsidebar')

    <!-- Contenu principal de l'article -->
<main class="lg:col-span-6 order-1 lg:order-2">
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    <article class="bg-white p-6 rounded-xl shadow-sm mb-6">
        @auth
            @if(auth()->id() === $article->user_id)
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
            @endif
        @endauth
        {{-- … etc --}}
    </article>
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
