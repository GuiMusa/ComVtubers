{{-- AFFICHAGE MOBILE & TABLETTE (Carrousel 5s compact) --}}
<div class="lg:hidden mb-6">
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-900 mb-3 flex items-center gap-2">
            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            Recommandés
        </h3>
        
        <div class="swiper recSwiper pb-8">
            <div class="swiper-wrapper">
                @forelse($recommendedArticles as $article)
                    <div class="swiper-slide h-auto">
                        {{-- Carte compacte horizontale --}}
                        <div class="border border-gray-100 rounded-lg p-2 h-full flex gap-3 items-center mx-1 bg-gray-50 hover:bg-gray-100 transition-colors">
                            @if($article->media)
                                <a href="{{ route('articles.show', $article->id) }}" class="block w-16 h-16 shrink-0 overflow-hidden rounded-md bg-gray-200">
                                    <img src="{{ asset('storage/' . $article->media) }}" alt="{{ $article->titre }}" class="w-full h-full object-cover">
                                </a>
                            @endif
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('articles.show', $article->id) }}" class="block text-sm font-semibold text-gray-900 hover:text-blue-600 line-clamp-2 leading-tight mb-1">
                                    {{ $article->titre }}
                                </a>
                                <p class="text-[10px] text-gray-500">{{ \Carbon\Carbon::parse($article->date)->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="swiper-slide text-sm text-gray-400">Aucune recommandation</div>
                @endforelse
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</div>

{{-- AFFICHAGE DESKTOP (Inchangé) --}}
<aside class="hidden lg:block lg:col-span-3 lg:order-3">
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-900 mb-3">Recommandés</h3>
        <ul class="space-y-3">
            @forelse($recommendedArticles as $article)
                <li class="border-b border-gray-100 pb-3 last:border-0 last:pb-0">
                    @if($article->media)
                        <a href="{{ route('articles.show', $article->id) }}" class="block mb-2 overflow-hidden rounded-lg">
                            <img src="{{ asset('storage/' . $article->media) }}" alt="{{ $article->titre }}" class="w-full h-32 object-cover hover:scale-105 transition-transform duration-300">
                        </a>
                    @endif
                    <a href="{{ route('articles.show', $article->id) }}" class="block text-sm font-semibold text-gray-900 hover:text-blue-600 truncate" title="{{ $article->titre }}">
                        {{ $article->titre }}
                    </a>
                    <p class="text-xs text-gray-500 mt-1">Publié le {{ \Carbon\Carbon::parse($article->date)->format('d/m/Y') }}</p>
                </li>
            @empty
                <li class="text-sm text-gray-400">Aucune recommandation</li>
            @endforelse
        </ul>
    </div>
</aside>