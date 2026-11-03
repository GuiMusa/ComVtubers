<aside class="lg:col-span-3 order-3 lg:order-3">
    <div class="bg-white rounded-xl shadow-sm p-4">
        <h3 class="text-lg font-semibold mb-3">Articles recommandés</h3>
        <ul class="space-y-3">
            @forelse($recommendedArticles as $article)
                <li class="border-b border-gray-100 pb-3 last:border-0 last:pb-0">
                    @if($article->media)
                        <a href="{{ route('articles.show', $article->id) }}" class="block mb-2">
                            <img src="{{ asset('storage/' . $article->media) }}"
                                 alt="{{ $article->titre }}"
                                 class="w-full h-32 object-cover rounded-lg">
                        </a>
                    @endif
                    <a href="{{ route('articles.show', $article->id) }}"
                       class="block text-sm font-medium text-blue-600 hover:underline leading-snug">
                        {{ $article->titre }}
                    </a>
                    <p class="text-xs text-gray-500 mt-1">
                        Publié le {{ \Carbon\Carbon::parse($article->date)->format('d/m/Y') }}
                    </p>
                </li>
            @empty
                <li class="text-sm text-gray-400">Aucune recommandation</li>
            @endforelse
        </ul>
    </div>
</aside>