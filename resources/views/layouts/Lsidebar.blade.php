{{-- AFFICHAGE MOBILE & TABLETTE (Accordéon) --}}
<div class="lg:hidden mb-4" x-data="{ open: false }">
    <button @click="open = !open" class="w-full flex justify-between items-center bg-white p-4 rounded-xl shadow-sm border border-gray-100 font-bold text-gray-900 hover:bg-gray-50 transition-colors">
        <span>Récent</span>
        <svg class="w-5 h-5 text-gray-500 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
    </button>
    <div x-show="open" x-collapse x-cloak class="mt-2 bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <ul class="space-y-1">
            <li x-data="{ openSub: false }">
                <button @click="openSub = !openSub" class="w-full flex justify-between items-center px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50 transition font-medium text-sm">
                    <span>Mes articles</span>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-90': openSub}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
                <ul x-show="openSub" x-cloak x-collapse class="pl-4 mt-1 space-y-1">
                    @auth
                        @forelse($userArticles as $article)
                            <li><a href="{{ route('articles.show', $article->id) }}" class="block px-3 py-1 text-sm text-gray-600 hover:text-blue-600 truncate">{{ $article->titre }}</a></li>
                        @empty
                            <li class="px-3 py-1 text-sm text-gray-400">Aucun article</li>
                        @endforelse
                    @else
                        <li class="px-3 py-1 text-sm text-gray-400">Connectez-vous</li>
                    @endauth
                </ul>
            </li>
            <li x-data="{ openSub: false }">
                <button @click="openSub = !openSub" class="w-full flex justify-between items-center px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50 transition font-medium text-sm">
                    <span>Derniers vus</span>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-90': openSub}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
                <ul x-show="openSub" x-cloak x-collapse class="pl-4 mt-1 space-y-1">
                    @forelse($latestArticles as $article)
                        <li><a href="{{ route('articles.show', $article->id) }}" class="block px-3 py-1 text-sm text-gray-600 hover:text-blue-600 truncate">{{ $article->titre }}</a></li>
                    @empty
                        <li class="px-3 py-1 text-sm text-gray-400">Aucun article</li>
                    @endforelse
                </ul>
            </li>
        </ul>
    </div>
</div>

{{-- AFFICHAGE DESKTOP --}}
<aside class="hidden lg:block lg:col-span-3 order-2 lg:order-1">
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-900 mb-3">Récent</h3>
        <ul class="space-y-1">
            <li x-data="{ open: false }">
                <button @click="open = !open" class="w-full flex justify-between items-center px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50 transition font-medium">
                    <span>Mes articles</span>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-90': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
                <ul x-show="open" x-cloak x-collapse class="pl-4 mt-1 space-y-1">
                    @auth
                        @forelse($userArticles as $article)
                            <li><a href="{{ route('articles.show', $article->id) }}" class="block px-3 py-1.5 text-sm text-gray-600 hover:text-blue-600 hover:bg-gray-50 rounded-lg truncate">{{ $article->titre }}</a></li>
                        @empty
                            <li class="px-3 py-1 text-sm text-gray-400">Aucun article</li>
                        @endforelse
                    @else
                        <li class="px-3 py-1 text-sm text-gray-400">Connectez-vous</li>
                    @endauth
                </ul>
            </li>
            <li x-data="{ open: false }">
                <button @click="open = !open" class="w-full flex justify-between items-center px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50 transition font-medium">
                    <span>Derniers vus</span>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-90': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
                <ul x-show="open" x-cloak x-collapse class="pl-4 mt-1 space-y-1">
                    @forelse($latestArticles as $article)
                        <li><a href="{{ route('articles.show', $article->id) }}" class="block px-3 py-1.5 text-sm text-gray-600 hover:text-blue-600 hover:bg-gray-50 rounded-lg truncate">{{ $article->titre }}</a></li>
                    @empty
                        <li class="px-3 py-1 text-sm text-gray-400">Aucun article</li>
                    @endforelse
                </ul>
            </li>
        </ul>
    </div>
</aside>