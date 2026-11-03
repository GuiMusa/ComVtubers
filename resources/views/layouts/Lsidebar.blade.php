<aside class="lg:col-span-3 order-2 lg:order-1">
    <div class="bg-white rounded-xl shadow-sm p-4">
        <h3 class="text-lg font-semibold mb-3">Articles récemment visité</h3>
        <ul class="space-y-1">

            {{-- MES ARTICLES --}}
            <li x-data="{ open: false }">
                <button @click="open = !open"
                        class="w-full flex justify-between items-center px-3 py-2 rounded-lg text-gray-900 hover:bg-gray-50 transition">
                    <span>Mes articles</span>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-90': open}"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
                <ul x-show="open" x-cloak x-collapse class="pl-4 mt-1 space-y-1">
                    @auth
                        @forelse($userArticles as $article)
                            <li>
                                <a href="{{ route('articles.show', $article->id) }}"
                                   class="block px-3 py-1 text-sm text-gray-600 hover:text-blue-600 hover:bg-gray-50 rounded-lg truncate">
                                    {{ $article->titre }}
                                </a>
                            </li>
                        @empty
                            <li class="px-3 py-1 text-sm text-gray-400">Aucun article</li>
                        @endforelse
                    @else
                        <li class="px-3 py-1 text-sm text-gray-400">Connectez-vous pour voir vos articles</li>
                    @endauth
                </ul>
            </li>

            {{-- DERNIERS VUS --}}
            <li x-data="{ open: false }">
                <button @click="open = !open"
                        class="w-full flex justify-between items-center px-3 py-2 rounded-lg text-gray-900 hover:bg-gray-50 transition">
                    <span>Derniers vus</span>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-90': open}"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
                <ul x-show="open" x-cloak x-collapse class="pl-4 mt-1 space-y-1">
                    @forelse($latestArticles as $article)
                        <li>
                            <a href="{{ route('articles.show', $article->id) }}"
                               class="block px-3 py-1 text-sm text-gray-600 hover:text-blue-600 hover:bg-gray-50 rounded-lg truncate">
                                {{ $article->titre }}
                            </a>
                        </li>
                    @empty
                        <li class="px-3 py-1 text-sm text-gray-400">Aucun article pour le moment</li>
                    @endforelse
                </ul>
            </li>

        </ul>
    </div>
</aside>