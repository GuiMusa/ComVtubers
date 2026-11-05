@extends('layouts.base')

@section('title', 'Accueil du Forum')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
    /* Décaler les points de pagination vers le bas pour éviter le chevauchement */
    .mainSwiper .swiper-pagination {
        bottom: 0px !important;
    }
    .recSwiper .swiper-pagination {
        bottom: 0px !important;
    }
</style>
@endpush

@section('content-with-sidebar')
    @include('layouts.Lsidebar')

    {{-- J'ai retiré "order-1" ici pour que le contenu reste au milieu --}}
    <main class="lg:col-span-6 lg:order-2 w-full overflow-hidden">
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl flex justify-between items-center shadow-sm">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800 transition-colors">✕</button>
            </div>
        @endif

        {{-- En-tête --}}
        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-3 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Les articles récents</h1>
                <p class="text-sm text-gray-500 mt-1">Découvrez les dernières publications de la communauté.</p>
            </div>
            @auth
                <a href="{{ route('articles.create') }}"
                   class="inline-block px-4 py-2 bg-blue-600 text-white rounded-xl shadow-sm hover:bg-blue-700 text-sm font-medium text-center md:hidden transition-colors">
                    Créer un article
                </a>
            @endauth
        </div>

        {{-- MOBILE : Carrousel Swiper (Plus grand, 1 carte + aperçu de la suivante) --}}
        <div class="lg:hidden mb-8">
            {{-- pb-12 ajoute de l'espace en bas pour les points de pagination --}}
            <div class="swiper mainSwiper pb-12">
                <div class="swiper-wrapper">
                    @foreach($articles as $article)
                        <div class="swiper-slide h-auto">
                            <article class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden h-full flex flex-col mx-1">
                                @if($article->media)
                                    <a href="{{ route('articles.show', $article->id) }}" class="block relative overflow-hidden aspect-video bg-gray-100">
                                        @php
                                            $extension = pathinfo($article->media, PATHINFO_EXTENSION);
                                            $is_video = in_array(strtolower($extension), ['mp4', 'mov', 'avi']);
                                        @endphp
                                        @if($is_video)
                                            <div class="absolute inset-0 flex items-center justify-center bg-black/40 z-10">
                                                <svg class="w-8 h-8 text-white drop-shadow-lg" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                            </div>
                                            <video class="w-full h-full object-cover"><source src="{{ asset('storage/' . $article->media) }}"></video>
                                        @else
                                            <img src="{{ asset('storage/' . $article->media) }}" alt="{{ $article->titre }}" class="w-full h-full object-cover">
                                        @endif
                                    </a>
                                @endif
                                <div class="p-4 flex-1 flex flex-col">
                                    @if($article->categorie)
                                        <div class="mb-2"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100">{{ $article->categorie->nom }}</span></div>
                                    @endif
                                    <h2 class="font-bold text-base mb-2 leading-snug">
                                        <a href="{{ route('articles.show', $article->id) }}" class="text-gray-900 hover:text-blue-600 transition-colors line-clamp-2">
                                            {{ $article->titre }}
                                        </a>
                                    </h2>
                                    <div class="mt-auto pt-3 flex items-center justify-between border-t border-gray-50 text-xs text-gray-500">
                                        <span class="truncate max-w-[100px]">{{ $article->user->name ?? 'Anonyme' }}</span>
                                        <span>{{ \Carbon\Carbon::parse($article->date)->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>

        {{-- DESKTOP : Grille classique --}}
        <div class="hidden lg:grid grid-cols-2 gap-6">
            @forelse($articles as $article)
                <article class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col group">
                    @if($article->media)
                        <a href="{{ route('articles.show', $article->id) }}" class="block relative overflow-hidden aspect-video bg-gray-100">
                            @php $is_video = in_array(strtolower(pathinfo($article->media, PATHINFO_EXTENSION)), ['mp4', 'mov', 'avi']); @endphp
                            @if($is_video)
                                <div class="absolute inset-0 flex items-center justify-center bg-black/40 z-10 group-hover:bg-black/20 transition-colors">
                                    <svg class="w-12 h-12 text-white drop-shadow-lg" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </div>
                                <video class="w-full h-full object-cover"><source src="{{ asset('storage/' . $article->media) }}"></video>
                            @else
                                <img src="{{ asset('storage/' . $article->media) }}" alt="{{ $article->titre }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @endif
                        </a>
                    @endif
                    <div class="p-5 flex-1 flex flex-col">
                        @if($article->categorie)
                            <div class="mb-3"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100">{{ $article->categorie->nom }}</span></div>
                        @endif
                        <h2 class="font-bold text-lg mb-2 leading-snug">
                            <a href="{{ route('articles.show', $article->id) }}" class="text-gray-900 hover:text-blue-600 transition-colors line-clamp-2">{{ $article->titre }}</a>
                        </h2>
                        <div class="mt-auto pt-4 flex items-center justify-between border-t border-gray-50 text-xs text-gray-500">
                            <div class="flex items-center gap-1.5"><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg><span class="truncate max-w-[100px]">{{ $article->user->name ?? 'Anonyme' }}</span></div>
                            <div class="flex items-center gap-1.5"><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg><span>{{ \Carbon\Carbon::parse($article->date)->format('d/m/Y') }}</span></div>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full p-8 text-center bg-white border border-gray-100 rounded-2xl shadow-sm">
                    <h3 class="text-lg font-medium text-gray-900">Aucun article</h3>
                </div>
            @endforelse
        </div>

        {{-- Pagination (Desktop uniquement) --}}
        @if($articles->hasPages())
            <div class="hidden lg:flex mt-8 justify-center">
                {{ $articles->links('components.custom-paginate') }}
            </div>
        @endif
    </main>

    @include('layouts.Rsidebar')
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Carrousel Principal (10s) - Affichage de 1.2 cartes pour qu'elles soient plus grandes
        new Swiper('.mainSwiper', {
            slidesPerView: 1.2,    // Modifié pour agrandir la carte
            spaceBetween: 16,      // Un peu plus d'espace
            loop: true,
            autoplay: {
                delay: 10000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.mainSwiper .swiper-pagination', // Ciblage précis
                clickable: true,
            }
        });

        // Carrousel Recommandés (5s) - Format compact
        new Swiper('.recSwiper', {
            slidesPerView: 1.2, 
            spaceBetween: 12,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.recSwiper .swiper-pagination', // Ciblage précis
                clickable: true,
            }
        });
    });
</script>
@endpush