@extends('layouts.base')

@section('title', $article->titre)

{{-- 1. On charge Swiper CSS pour le carrousel "Recommandés" sur mobile --}}
@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
    .recSwiper .swiper-pagination {
        bottom: 0px !important;
    }
</style>
@endpush

@section('content-with-sidebar')
    <!-- Barre latérale gauche (Sur mobile : Accordéon "Récent" en haut) -->
    <div class="order-1 lg:order-1 lg:col-span-3">
        @include('layouts.Lsidebar')
    </div>

    <!-- Contenu principal de l'article (Sur mobile : Article au milieu) -->
    <main class="order-2 lg:order-2 lg:col-span-6">
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 p-4 rounded-xl mb-6 shadow-sm flex items-center gap-2" role="alert">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <article class="bg-white p-5 md:p-6 rounded-2xl shadow-sm border border-gray-100 mb-6">
            @auth
                @can('update', $article)
                    <div class="flex justify-end gap-2 mb-4">
                        <a href="{{ route('articles.edit', $article) }}"
                        class="px-3 py-1.5 text-sm border border-amber-500 text-amber-600 rounded-lg hover:bg-amber-50 transition-colors">
                            Modifier
                        </a>
                        <form action="{{ route('articles.destroy', $article) }}" method="POST"
                            onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">
                            @csrf @method('DELETE')
                            <button class="px-3 py-1.5 text-sm border border-red-500 text-red-600 rounded-lg hover:bg-red-50 transition-colors">
                                Supprimer
                            </button>
                        </form>
                    </div>
                @endcan
            @endauth

            {{-- Titre et métadonnées --}}
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3 leading-tight">
                {{ $article->titre }}
            </h1>
            
            <div class="flex flex-wrap items-center text-sm text-gray-500 mb-6 gap-2">
                <span>Publié le {{ \Carbon\Carbon::parse($article->date)->format('d/m/Y') }}</span>
                <span>•</span>
                <span>Par <strong class="text-gray-700">{{ $article->user->name ?? 'Auteur inconnu' }}</strong></span>
                @if($article->categorie)
                    <span>•</span>
                    <span class="bg-blue-50 text-blue-700 border border-blue-100 px-2.5 py-0.5 rounded-full text-xs font-bold">
                        {{ $article->categorie->nom }}
                    </span>
                @endif
            </div>

            {{-- Média (Image ou Vidéo) --}}
            @if($article->media)
                <div class="mb-6 rounded-xl overflow-hidden shadow-sm bg-gray-100 flex justify-center border border-gray-100">
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
            <div class="text-gray-700 leading-relaxed whitespace-pre-line text-base md:text-lg">
                {{ $article->contenu }}
            </div>
        </article>

                {{-- SECTION COMMENTAIRES --}}
        <section class="bg-white p-5 md:p-6 rounded-2xl shadow-sm border border-gray-100 mb-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                Commentaires ({{ $article->commentaires->count() }})
            </h2>

            @auth
                {{-- Formulaire principal --}}
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 mb-6">
                    <form action="{{ route('commentaires.store', $article->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <textarea name="contenu" class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors outline-none text-gray-900 placeholder-gray-400 resize-none @error('contenu') border-red-500 @enderror" rows="3" placeholder="Laissez un commentaire..." required></textarea>
                            @error('contenu')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-bold transition-colors shadow-sm">
                            Envoyer
                        </button>
                    </form>
                </div>
            @else
                <div class="bg-blue-50 text-center p-4 rounded-xl border border-blue-100 mb-6">
                    <p class="text-blue-800"><a href="{{ route('login') }}" class="font-bold underline hover:text-blue-900">Connectez-vous</a> pour laisser un commentaire.</p>
                </div>
            @endauth

            {{-- Liste des commentaires --}}
            <div class="space-y-4">
                @forelse($article->commentaires->where('parent_id', null)->sortByDesc('date') as $commentaire)
                    @include('partials.commentaire', ['commentaire' => $commentaire, 'article' => $article])
                @empty
                    <div class="text-center p-6 text-gray-500 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                        Soyez le premier à commenter cet article !
                    </div>
                @endforelse
            </div>
        </section>
    </main>

    <!-- Barre latérale droite (Sur mobile : Carrousel "Recommandés" en bas) -->
    <div class="order-3 lg:order-3 lg:col-span-3">
        @include('layouts.Rsidebar')
    </div>
    
    {{-- SCRIPTS JAVASCRIPT --}}
    <script>
        function toggleReplyForm(commentId) {
            const form = document.getElementById('reply-form-' + commentId);
            form.classList.toggle('hidden');
        }

        function toggleEditForm(commentId) {
            const content = document.getElementById('comment-content-' + commentId);
            const form = document.getElementById('edit-form-' + commentId);
            
            form.classList.toggle('hidden');
            content.classList.toggle('hidden');
        }
    </script>
    @endsection

{{-- 2. On charge Swiper JS et on l'initialise pour le carrousel des recommandations --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialisation du carrousel "Recommandés" (Mobile / Tablette)
        new Swiper('.recSwiper', {
            slidesPerView: 1.2, 
            spaceBetween: 12,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.recSwiper .swiper-pagination',
                clickable: true,
            }
        });
    });
</script>
@endpush