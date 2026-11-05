@extends('layouts.base')

@section('title', 'Accueil du Forum')

@section('content-with-sidebar')
    @include('layouts.Lsidebar')

    <main class="lg:col-span-6 order-1 lg:order-2">
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

        {{-- Liste des articles (Cartes Contemporaines) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            @forelse($articles as $article)
                <article class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col group">
                    
                    {{-- Média (Image/Vidéo) --}}
                    @if($article->media)
                        <a href="{{ route('articles.show', $article->id) }}" class="block relative overflow-hidden aspect-video bg-gray-100">
                            @php
                                $extension = pathinfo($article->media, PATHINFO_EXTENSION);
                                $is_video = in_array(strtolower($extension), ['mp4', 'mov', 'avi']);
                            @endphp
                            @if($is_video)
                                <div class="absolute inset-0 flex items-center justify-center bg-black/40 z-10 group-hover:bg-black/20 transition-colors">
                                    <svg class="w-12 h-12 text-white drop-shadow-lg" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </div>
                                <video class="w-full h-full object-cover">
                                    <source src="{{ asset('storage/' . $article->media) }}">
                                </video>
                            @else
                                <img src="{{ asset('storage/' . $article->media) }}"
                                     alt="{{ $article->titre }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @endif
                        </a>
                    @endif

                    {{-- Contenu de la carte --}}
                    <div class="p-5 flex-1 flex flex-col">
                        {{-- Catégorie --}}
                        @if($article->categorie)
                            <div class="mb-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                    {{ $article->categorie->nom }}
                                </span>
                            </div>
                        @endif

                        {{-- Titre --}}
                        <h2 class="font-bold text-lg mb-2 leading-snug">
                            <a href="{{ route('articles.show', $article->id) }}" class="text-gray-900 hover:text-blue-600 transition-colors line-clamp-2">
                                {{ $article->titre }}
                            </a>
                        </h2>

                        {{-- Métadonnées (Auteur, Date, Favoris) --}}
                        <div class="mt-auto pt-4 flex items-center justify-between border-t border-gray-50 text-xs text-gray-500">
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                <span class="truncate max-w-[100px]">{{ $article->user->name ?? 'Anonyme' }}</span>
                            </div>
                            
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span>{{ \Carbon\Carbon::parse($article->date)->format('d/m/Y') }}</span>
                            </div>

                            @if($article->favoris)
                                <span class="text-yellow-500" title="Article favoris">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                </span>
                            @endif
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full p-8 text-center bg-white border border-gray-100 rounded-2xl shadow-sm">
                    <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    <h3 class="text-lg font-medium text-gray-900">Aucun article</h3>
                    <p class="mt-1 text-sm text-gray-500">Il n'y a pas encore de publications pour le moment.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination (en bas, au format Tailwind) --}}
        @if($articles->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $articles->links('pagination::tailwind') }}
            </div>
        @endif
    </main>

    @include('layouts.Rsidebar')
@endsection