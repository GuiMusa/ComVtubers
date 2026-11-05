@extends('layouts.base')

@section('title', 'Accueil du Forum')

@section('content-with-sidebar')
    @include('layouts.Lsidebar')

    <main class="lg:col-span-6 order-1 lg:order-2">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg flex justify-between items-center">
                {{ session('success') }}
                <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">✕</button>
            </div>
        @endif

        {{-- En-tête --}}
        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-3 mb-4">
            <h1 class="text-2xl font-bold">Les articles récents</h1>
            @auth
                <a href="{{ route('articles.create') }}"
                   class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium text-center md:hidden">
                    Créer un article
                </a>
            @endauth
        </div>

        {{-- Pagination haut --}}
        <div class="flex justify-center mb-6">
            {{ $articles->links() }}
        </div>

        {{-- Liste des articles --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @forelse($articles as $article)
                <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-shadow flex flex-col">
                    @if($article->media)
                        <a href="{{ route('articles.show', $article->id) }}" class="block">
                            @php
                                $extension = pathinfo($article->media, PATHINFO_EXTENSION);
                                $is_video = in_array(strtolower($extension), ['mp4', 'mov', 'avi']);
                            @endphp
                            @if($is_video)
                                <div class="aspect-video bg-black">
                                    <video class="w-full h-full object-cover">
                                        <source src="{{ asset('storage/' . $article->media) }}">
                                    </video>
                                </div>
                            @else
                                <img src="{{ asset('storage/' . $article->media) }}"
                                     alt="{{ $article->titre }}"
                                     class="w-full h-48 object-cover">
                            @endif
                        </a>
                    @endif
                    <div class="p-4 flex-1 flex flex-col">
                        <h2 class="font-bold text-lg mb-2">
                            <a href="{{ route('articles.show', $article->id) }}" class="text-gray-900 hover:text-blue-600">
                                {{ $article->titre }}
                            </a>
                        </h2>
                        <p class="text-xs text-gray-500 mb-2">
                            Publié le {{ \Carbon\Carbon::parse($article->date)->format('d/m/Y à H:i') }}
                            @if($article->user)
                                par <strong>{{ $article->user->name }}</strong>
                            @endif
                        </p>
                        @if($article->categorie)
                            <div class="mb-2 mt-auto">
                                <span class="inline-block px-2 py-1 text-xs font-semibold bg-gray-200 text-gray-800 rounded">{{ $article->categorie->nom }}</span>
                            </div>
                        @endif
                        @if($article->favoris)
                            <span class="inline-block px-2 py-1 text-xs font-semibold bg-yellow-100 text-yellow-800 rounded">⭐ Favoris</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full p-4 bg-blue-50 border border-blue-200 text-blue-800 rounded-lg">
                    Aucun article disponible pour le moment.
                </div>
            @endforelse
        </div>

        {{-- Pagination bas --}}
        <div class="flex justify-center mt-6">
            {{ $articles->links() }}
        </div>
    </main>

    @include('layouts.Rsidebar')
@endsection