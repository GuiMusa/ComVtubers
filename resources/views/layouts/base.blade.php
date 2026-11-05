<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Forum de discussion')</title>

    {{-- ⚠️ On charge Tailwind via Vite (plus de CDN Bootstrap) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- <style>
        [x-cloak] { display: none !important; }
    </style> --}}
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

        {{-- ============================================ --}}
    {{-- HEADER --}}
    {{-- ============================================ --}}
    <header class="bg-white shadow-sm sticky top-0 z-40" x-data="{ mobileMenu: false, userMenu: false }">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between h-16 gap-4">

                {{-- 1. Logo (Toujours visible) --}}
                <a href="{{ route('home') }}" class="text-xl font-bold text-gray-900 shrink-0">ComVtuber</a>

                {{-- 2. Recherche (Visible sur Mobile ET Desktop) --}}
                {{-- On enlève le "hidden md:flex" pour qu'elle soit toujours là --}}
                <form action="{{ route('home') }}" method="GET" class="flex flex-1 max-w-xs mx-2 md:mx-0">
                    <input type="search" name="q" placeholder="Rechercher un sujet..."
                           value="{{ request('q') }}"
                           class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                </form>

                {{-- 3. Navigation Desktop (Cachée sur mobile grâce à "hidden") --}}
                <nav class="hidden lg:flex items-center gap-1">
                    <a href="{{ route('home') }}" class="px-3 py-2 rounded-lg bg-blue-600 text-white text-sm font-medium">Accueil</a>
                    <a href="#" class="px-3 py-2 rounded-lg text-blue-600 hover:bg-blue-50 text-sm font-medium">Articles</a>
                    <a href="#" class="px-3 py-2 rounded-lg text-blue-600 hover:bg-blue-50 text-sm font-medium">Vtubers</a>
                    
                </nav>
                {{-- 4. User Desktop --}}
                @auth
                    <div class="hidden lg:flex items-center gap-3">
                        {{-- Bouton Nouvel Article --}}
                        @can('create', \App\Models\Article::class)
                            <a href="{{ route('articles.create') }}"
                               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium transition-colors shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14M5 12h14"/>
                                </svg>
                                Nouvel article
                            </a>
                        @endcan

                        {{-- Menu Utilisateur --}}
                        <div class="relative">
                            <button @click="userMenu = !userMenu"
                                    class="flex items-center gap-2 px-4 py-2 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 text-sm transition-colors">
                                {{ Auth::user()->name }}
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            
                            <div x-show="userMenu" x-cloak @click.outside="userMenu = false"
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 border border-gray-100 z-50">
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Tableau de bord</a>
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Mon Profil</a>
                                <hr class="my-1 border-gray-100">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Déconnexion</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="hidden lg:inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium">Connexion</a>
                @endauth

                {{-- 5. Actions Mobile & Tablette (Hamburger + Bouton Tablette) --}}
                <div class="flex items-center gap-2 lg:hidden">
                    {{-- Bouton Nouvel Article (Affiché uniquement sur Tablette : md à lg) --}}
                    @auth
                        @can('create', \App\Models\Article::class)
                            <a href="{{ route('articles.create') }}"
                               class="hidden md:inline-flex items-center gap-1.5 px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium transition-colors shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14M5 12h14"/>
                                </svg>
                                Nouvel article
                            </a>
                        @endcan
                    @endauth

                    {{-- Hamburger mobile (Visible sur Mobile et Tablette, caché sur Desktop) --}}
                    <button @click="mobileMenu = !mobileMenu" class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            <path x-show="mobileMenu" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
            {{-- 6. Menu mobile (Collapse) --}}
            <div x-show="mobileMenu" x-cloak x-collapse class="lg:hidden pb-4 space-y-2 border-t border-gray-100 pt-2">
                {{-- ⚠️ J'ai supprimé la barre de recherche ici comme demandé --}}
                
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg bg-blue-600 text-white text-sm font-medium">Accueil</a>
                <a href="#" class="block px-3 py-2 rounded-lg text-blue-600 hover:bg-blue-50 text-sm font-medium">Articles</a>
                <a href="#" class="block px-3 py-2 rounded-lg text-blue-600 hover:bg-blue-50 text-sm font-medium">Vtubers</a>
                
                @auth
                    <hr class="border-gray-100">
                    <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100 text-sm">Tableau de bord</a>
                    <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100 text-sm">Mon Profil</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100 text-sm">Déconnexion</button>
                    </form>
                @else
                    <hr class="border-gray-100">
                    <a href="{{ route('login') }}" class="block px-3 py-2 bg-blue-600 text-white rounded-lg text-center text-sm font-medium">Connexion</a>
                @endauth
            </div>
        </div>
    </header>

    {{-- ============================================ --}}
    {{-- CONTENU PRINCIPAL --}}
    {{-- ============================================ --}}
    <main class="flex-1 max-w-7xl mx-auto px-4 py-6 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            @yield('content-with-sidebar')
        </div>
    </main>

    {{-- ============================================ --}}
    {{-- FOOTER --}}
    {{-- ============================================ --}}
    <footer class="bg-white border-t border-gray-200 py-4 mt-auto">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} ComVtuber. Tous droits réservés.
        </div>
    </footer>

    {{-- Back to top --}}
    <button id="back-to-top"
            class="hidden fixed bottom-6 right-6 w-12 h-12 bg-blue-600 text-white rounded-full shadow-lg hover:bg-blue-700 z-50 flex items-center justify-center">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
        </svg>
    </button>

    <script>
        const backToTop = document.getElementById('back-to-top');
        window.addEventListener('scroll', () => {
            backToTop.classList.toggle('hidden', window.scrollY < 200);
        });
        backToTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    </script>
</body>
</html>