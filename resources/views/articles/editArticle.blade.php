@extends('layouts.base')

@section('title', 'Modifier : ' . $article->titre)
 
@section('content-with-sidebar')
    <!-- Barre latérale gauche -->
    <div class="hidden lg:block lg:col-span-3 order-2 lg:order-1">
        @include('layouts.Lsidebar')
    </div>

    <!-- Contenu principal -->
    <main class="col-span-1 lg:col-span-6 order-1 lg:order-2">
        <!-- Carte Contemporaine -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            
            <!-- En-tête de la carte -->
            <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Modifier l'article</h1>
                    <p class="mt-1 text-sm text-gray-500">Mettez à jour le contenu de votre publication.</p>
                </div>
                <a href="{{ route('articles.show', $article->id) }}" class="text-sm text-gray-500 hover:text-gray-800 underline">
                    Retour
                </a>
            </div>

            <div class="p-6 md:p-8">
                {{-- Affichage des erreurs de validation --}}
                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-red-500 mt-0.5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <h3 class="text-sm font-medium text-red-800">Veuillez corriger les erreurs suivantes :</h3>
                                <ul class="mt-2 text-sm text-red-700 list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('articles.update', $article->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    {{-- Titre --}}
                    <div>
                        <label for="titre" class="block text-sm font-semibold text-gray-700 mb-2">Titre de l'article <span class="text-red-500">*</span></label>
                        <input type="text" id="titre" name="titre" value="{{ old('titre', $article->titre) }}" required
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors outline-none text-gray-900 placeholder-gray-400">
                    </div>

                    {{-- Catégorie --}}
                    <div>
                        <label for="categorie_id" class="block text-sm font-semibold text-gray-700 mb-2">Catégorie <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select id="categorie_id" name="categorie_id" required
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors outline-none text-gray-900 appearance-none cursor-pointer">
                                @foreach($categories as $categorie)
                                    <option value="{{ $categorie->id }}" {{ old('categorie_id', $article->categorie_id) == $categorie->id ? 'selected' : '' }}>
                                        {{ $categorie->nom }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Contenu --}}
                    <div>
                        <label for="contenu" class="block text-sm font-semibold text-gray-700 mb-2">Message <span class="text-red-500">*</span></label>
                        <textarea id="contenu" name="contenu" rows="8" required
                                  class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors outline-none text-gray-900 placeholder-gray-400 resize-none">{{ old('contenu', $article->contenu) }}</textarea>
                    </div>

                    {{-- Média (Fichier) --}}
                    <div x-data="{ fileName: '' }">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Modifier l'image ou la vidéo (Optionnel)</label>
                        
                        @if($article->media)
                            <div class="mb-4 p-3 bg-gray-50 border border-gray-200 rounded-xl flex items-center gap-4">
                                @php
                                    $extension = strtolower(pathinfo($article->media, PATHINFO_EXTENSION));
                                    $is_video = in_array($extension, ['mp4', 'mov', 'avi']);
                                @endphp
                                
                                {{-- Vignette --}}
                                <div class="shrink-0 w-16 h-16 rounded-lg overflow-hidden bg-gray-200 border border-gray-300 relative flex items-center justify-center">
                                    @if($is_video)
                                        <video class="w-full h-full object-cover">
                                            <source src="{{ asset('storage/' . $article->media) }}" type="video/{{ $extension }}">
                                        </video>
                                        <div class="absolute inset-0 bg-black/30 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/></svg>
                                        </div>
                                    @else
                                        <img src="{{ asset('storage/' . $article->media) }}" alt="Média actuel" class="w-full h-full object-cover">
                                    @endif
                                </div>

                                <div class="text-sm overflow-hidden">
                                    <span class="font-medium text-gray-900 block truncate" title="{{ basename($article->media) }}">
                                        {{ basename($article->media) }}
                                    </span>
                                    <p class="text-xs text-gray-500 mt-1">Laissez vide pour conserver ce fichier.</p>
                                </div>
                            </div>
                        @endif
                        
                        {{-- La zone cliquable --}}
                        <div class="relative mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-blue-400 transition-colors bg-gray-50 hover:bg-blue-50/30 group cursor-pointer overflow-hidden">
                            
                            <input id="media" name="media" type="file" 
                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                   accept="image/*,video/*"
                                   @change="fileName = $event.target.files[0] ? $event.target.files[0].name : ''">
                            
                            <div class="space-y-1 text-center pointer-events-none">
                                <svg class="mx-auto h-10 w-10 text-gray-400 group-hover:text-blue-500 transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <span class="relative rounded-md font-medium text-blue-600 group-hover:text-blue-500">
                                        <span x-text="fileName ? fileName : 'Remplacer le fichier'"></span>
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500" x-show="!fileName">PNG, JPG, MP4, MOV jusqu'à 10MB</p>
                                <p class="text-xs text-green-600 font-medium" x-show="fileName">Nouveau fichier sélectionné !</p>
                            </div>
                        </div>
                    </div>

                    {{-- Boutons d'action --}}
                    <div class="pt-4 flex flex-col sm:flex-row gap-3">
                        <button type="submit" class="w-full sm:flex-1 flex justify-center items-center gap-2 py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                            Enregistrer les modifications
                        </button>
                        <a href="{{ route('articles.show', $article->id) }}" class="w-full sm:w-auto flex justify-center py-3 px-6 border border-gray-300 rounded-xl shadow-sm text-sm font-bold text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>
 
    <!-- Barre latérale droite -->
    <div class="hidden lg:block lg:col-span-3 order-3">
        @include('layouts.Rsidebar')
    </div>
@endsection