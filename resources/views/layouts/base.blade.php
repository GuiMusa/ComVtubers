<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ComVtuber')</title>
    
    <!-- Google Fonts: Poppins for body, Lora for headings -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,600;1,400&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* --- THEME COZY / FANTASY --- */
        :root {
            --theme-bg: #fffaf0; /* Blanc crème (Floral White) */
            --theme-surface: #ffffff; /* Blanc pur pour les cartes */
            --theme-primary: #ffb6c1; /* Rose clair (Light Pink) */
            --theme-secondary: #ffb347; /* Pêche (Pastel Orange) */
            --theme-glow: #ffe4e1; /* Lueur rose très pâle (Misty Rose) */
            --theme-text: #5d4037; /* Brun foncé pour le texte */
            --theme-text-muted: #a1887f; /* Brun clair pour le texte secondaire */
            --font-body: 'Poppins', sans-serif;
            --font-heading: 'Lora', serif;
        }

        @keyframes subtle-gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        body {
            font-family: var(--font-body);
            color: var(--theme-text);
            background: linear-gradient(60deg, var(--theme-bg), #fff5e1, var(--theme-bg));
            background-size: 300% 300%;
            animation: subtle-gradient 20s ease infinite;
        }
        
        h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
            font-family: var(--font-heading);
            font-weight: 600;
            color: var(--theme-text);
        }

        /* --- HEADER --- */
        .header-vtuber {
            background-color: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--theme-glow);
        }
        .header-vtuber .navbar-brand {
            font-family: var(--font-heading);
            color: var(--theme-text);
            font-weight: 600;
        }
        .header-vtuber .nav-link {
            color: var(--theme-text-muted);
            font-weight: 600;
            transition: color 0.3s;
        }
        .header-vtuber .nav-link.active,
        .header-vtuber .nav-link:hover {
            color: var(--theme-primary);
        }
        .header-vtuber .search-box {
            background-color: #fff;
            border: 1px solid var(--theme-primary);
            color: var(--theme-text);
        }
        .header-vtuber .search-box::placeholder {
            color: var(--theme-text-muted);
        }
        .header-vtuber .btn-login {
            background-color: var(--theme-secondary);
            border: none;
            color: #fff;
            font-weight: 600;
            border-radius: 20px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .header-vtuber .btn-login:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(255, 179, 71, 0.4);
        }
        
        /* --- FOOTER --- */
        .footer-vtuber {
            background-color: transparent;
            border-top: 1px solid var(--theme-glow);
        }
        .footer-vtuber .text-muted {
             color: var(--theme-text-muted) !important;
        }

        /* --- REVOLUTIONARY FOOTER --- */
        @keyframes gentle-float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        @keyframes sparkle {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 1; transform: scale(1.2); }
        }

        .infinity-garden {
            position: relative;
            padding: 100px 0 50px;
            margin-top: 100px;
            background: linear-gradient(to top, #ffefea, var(--theme-bg));
            overflow: hidden;
        }

        .infinity-garden::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 100px;
            background: linear-gradient(to bottom, rgba(255, 250, 240, 0), var(--theme-bg));
            transform: translateY(-100%);
        }

        .stars, .twinkling {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
            display: block;
        }

        .stars {
            background: transparent url(https://www.script-tutorials.com/demos/360/images/stars.png) repeat top center;
            z-index: 1;
        }
        .twinkling {
            background: transparent url(https://www.script-tutorials.com/demos/360/images/twinkling.png) repeat top center;
            z-index: 2;
            animation: move-twink-back 200s linear infinite;
        }
        @keyframes move-twink-back {
            from {background-position:0 0;}
            to {background-position:-10000px 5000px;}
        }

        .footer-content {
            position: relative;
            z-index: 3;
            text-align: center;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin-bottom: 40px;
        }

        .orb-link {
            position: relative;
            width: 60px;
            height: 60px;
            background: rgba(255, 182, 193, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.4s ease;
            animation: gentle-float 6s ease-in-out infinite;
        }
        .orb-link i {
            color: #fff;
            font-size: 24px;
            text-shadow: 0 0 10px var(--theme-primary);
        }

        .orb-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: var(--theme-primary);
            filter: blur(15px);
            opacity: 0.8;
            transition: all 0.4s ease;
        }
        
        .orb-link .link-label {
            position: absolute;
            bottom: -25px;
            opacity: 0;
            color: var(--theme-text);
            font-weight: 600;
            transition: opacity 0.4s, bottom 0.4s;
        }
        
        .orb-link:hover {
            transform: translateY(-5px) scale(1.1);
            box-shadow: 0 0 25px var(--theme-primary);
        }
        .orb-link:hover::before {
            opacity: 1;
            transform: scale(1.2);
        }
        .orb-link:hover .link-label {
            opacity: 1;
            bottom: -35px;
        }
        
        .footer-cta h4 {
            font-size: 1.5rem;
            color: var(--theme-text);
            margin-bottom: 15px;
        }

        .newsletter-form {
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        .newsletter-form input {
            background: rgba(255,255,255,0.8);
            border: 1px solid var(--theme-primary);
            color: var(--theme-text);
            border-radius: 20px;
            padding: 10px 15px;
            width: 300px;
        }
         .newsletter-form button {
            background: var(--theme-secondary);
            color: #fff;
            border: none;
            border-radius: 20px;
            padding: 10px 20px;
            font-weight: 600;
        }

        .footer-copyright {
            margin-top: 50px;
            color: var(--theme-text-muted);
        }
        
        /* --- SCROLL TO TOP --- */
        #back-to-top {
            background-color: var(--theme-secondary);
            color: #fff;
            border: 2px solid #fff;
            transition: background-color 0.3s, transform 0.3s;
        }
        #back-to-top:hover {
            background-color: var(--theme-primary);
            transform: scale(1.1);
        }

        /* --- SIDEBAR ARROW --- */
        .arrow-indicator {
            border: solid var(--theme-text);
            border-width: 0 2px 2px 0;
        }

        /* --- ARTICLE CARDS & CONTENT --- */
        .article-card {
            background-color: var(--theme-surface);
            border: 1px solid #fff;
            box-shadow: 0 10px 25px -10px rgba(93, 64, 55, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 12px;
        }
        .article-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px -10px rgba(93, 64, 55, 0.3);
        }
        .article-card .article-cover-image {
            border-top-left-radius: 11px;
            border-top-right-radius: 11px;
        }
        .article-card h2 a {
            color: var(--theme-text);
            text-decoration: none;
            transition: color 0.3s;
        }
         .article-card h2 a:hover {
            color: var(--theme-primary);
        }
        .article-card .badge {
            background-color: var(--theme-secondary);
            color: #fff;
            font-weight: 400;
        }
        .article-card .btn-primary {
            background-color: transparent;
            border: 1px solid var(--theme-primary);
            color: var(--theme-primary);
            font-weight: 600;
            border-radius: 20px;
            transition: background-color 0.2s, color 0.2s;
        }
        .article-card .btn-primary:hover {
            background-color: var(--theme-primary);
            color: #fff;
        }
        .empty-state {
            background-color: var(--theme-surface);
            border: 2px dashed var(--theme-primary);
            color: var(--theme-text);
            box-shadow: 0 10px 25px -10px rgba(93, 64, 55, 0.2);
            border-radius: 12px;
        }
        .empty-state .btn-primary {
            background-color: var(--theme-primary);
            border: none;
            color: #fff;
        }

        .no-resize {
            resize: none;
        }

        /* --- SIDEBARS --- */
        .sidebar-block {
            background-color: rgba(255, 255, 255, 0.6);
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            box-shadow: 0 5px 15px -5px rgba(93, 64, 55, 0.1);
        }
        .sidebar-block h3 {
            color: var(--theme-text);
            border-bottom: 1px solid var(--theme-primary);
        }
        .sidebar-block a, .sidebar-block .nav-link {
            color: var(--theme-text-muted) !important;
            text-decoration: none;
            transition: color 0.2s;
        }
        .sidebar-block a:hover, .sidebar-block .nav-link:hover {
            color: var(--theme-primary) !important;
        }
        .sidebar-block .card-title {
            color: var(--theme-text) !important;
        }
        hr {
            border-color: var(--theme-glow);
        }

        /* --- DON JUAN SIDEBAR --- */
        .don-juan-sidebar .sidebar-title {
            font-family: var(--font-heading);
            font-style: italic;
            font-size: 1.5rem;
            text-align: center;
            color: var(--theme-primary);
            margin-bottom: 2rem;
            border-bottom: none;
        }
        .diary-card-container {
            position: relative;
            min-height: 250px;
        }
        .diary-card {
            position: absolute;
            width: 100%;
            padding: 20px;
            background: var(--theme-bg);
            border: 1px solid var(--theme-glow);
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
            cursor: pointer;
            text-decoration: none;
        }
        .diary-card:nth-child(1) { top: 0; z-index: 3; transform: rotate(-2deg); }
        .diary-card:nth-child(2) { top: 10px; transform: scale(0.95) rotate(1deg); z-index: 2; }
        .diary-card:nth-child(3) { top: 20px; transform: scale(0.9) rotate(3deg); z-index: 1; }
        .diary-card:nth-child(n+4) { display: none; } /* Show only 3 */

        .diary-card-container:hover .diary-card {
             transform: rotate(0) scale(1);
             top: 0;
        }
        .diary-card-container:hover .diary-card:not(:hover) {
            opacity: 0.5;
            filter: blur(1px);
        }
        .diary-card:hover {
            z-index: 4 !important;
            transform: translateY(-10px) scale(1.05) !important;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .diary-card .diary-title {
            font-family: var(--font-heading);
            font-style: italic;
            font-size: 1.1rem;
            margin-bottom: 5px;
            color: var(--theme-text);
        }
        .diary-card .diary-meta {
            font-size: 0.8rem;
            color: var(--theme-text-muted);
        }
        .diary-card .diary-image {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            object-fit: cover;
            position: absolute;
            right: -15px;
            top: -15px;
            border: 2px solid #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            opacity: 0;
            transform: translateY(10px) rotate(5deg);
            transition: opacity 0.4s, transform 0.4s;
            transition-delay: 0.1s;
        }
        .diary-card:hover .diary-image {
            opacity: 1;
            transform: translateY(0) rotate(0);
        }
        
        /* --- LOAD MORE BUTTON --- */
        #load-more {
            font-weight: 600;
            border-radius: 20px;
            border: 2px solid var(--theme-primary);
            color: var(--theme-primary);
            padding: 10px 30px;
        }
        #load-more:hover, #load-more:focus {
            background-color: var(--theme-primary);
            color: #fff;
            box-shadow: 0 4px 15px rgba(233, 30, 99, 0.3);
        }

        @stack('styles')
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    <header class="header-vtuber sticky-top py-3">
        <nav class="container">
            <div class="d-flex justify-content-between align-items-center">
                <a class="fs-4 fw-bold text-decoration-none navbar-brand" href="{{ route('home') }}">ComVtuber</a>
                <form class="d-flex" style="width: 300px;">
                    <input class="form-control me-2 search-box" type="search" placeholder="Rechercher..." aria-label="Search">
                </form>
                <ul class="nav">
                    <li class="nav-item"><a href="{{ route('home') }}" class="nav-link active" aria-current="page">Accueil</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Articles</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Vtubers</a></li>
                </ul>
                @guest
                    <a href="{{ route('login') }}" class="btn btn-login">Connexion</a>
                @else
                    {{-- Dropdown pour utilisateur connecté --}}
                    <div class="dropdown">
                        <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ Auth::user()->avatar_url ?? 'https://i.pravatar.cc/32' }}" alt="mdo" width="32" height="32" class="rounded-circle">
                        </a>
                        <ul class="dropdown-menu text-small shadow">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profil</a></li>
                            <li><a class="dropdown-item" href="#">Paramètres</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                        Déconnexion
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endguest
            </div>
        </nav>
    </header>

    <div class="container mt-4">
        <div class="row">
            @yield('content-with-sidebar')
        </div>
    </div>

    <footer class="infinity-garden">
        <div class="stars"></div>
        <div class="twinkling"></div>
        <div class="container footer-content">
            <div class="footer-links">
                <a href="#" class="orb-link" style="animation-delay: 0s;">
                    <i class="bi bi-house-heart-fill"></i>
                    <span class="link-label">Accueil</span>
                </a>
                <a href="#" class="orb-link" style="animation-delay: 1s;">
                    <i class="bi bi-twitter"></i>
                     <span class="link-label">Twitter</span>
                </a>
                <a href="#" class="orb-link" style="animation-delay: 2s;">
                    <i class="bi bi-discord"></i>
                     <span class="link-label">Discord</span>
                </a>
                <a href="#" class="orb-link" style="animation-delay: 3s;">
                    <i class="bi bi-envelope-heart-fill"></i>
                     <span class="link-label">Contact</span>
                </a>
            </div>
            <div class="footer-cta">
                <h4>Laissez une étoile dans notre jardin</h4>
                <form class="newsletter-form">
                    <input type="email" placeholder="votre.email@example.com">
                    <button type="submit">Envoyer</button>
                </form>
            </div>
            <div class="footer-copyright">
                <p>&copy; {{ date('Y') }} ComVtuber. Un univers de créativité.</p>
            </div>
        </div>
    </footer>

    <a href="#" id="back-to-top" title="Retour en haut">
        &uarr;
    </a>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Back to top button
            let mybutton = document.getElementById("back-to-top");
            if(mybutton) {
                window.onscroll = function() {
                    if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
                        mybutton.style.display = "block";
                    } else {
                        mybutton.style.display = "none";
                    }
                };
                mybutton.addEventListener('click', function(e) {
                    e.preventDefault();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            }

            // Parallax footer
            const footer = document.querySelector('.infinity-garden');
            if(footer) {
                const twinkling = footer.querySelector('.twinkling');
                window.addEventListener('scroll', function() {
                    const scrollY = window.scrollY;
                    const pageHeight = document.documentElement.scrollHeight - window.innerHeight;
                    const scrollFraction = scrollY / pageHeight;
                    
                    if (twinkling) {
                         // This creates a subtle effect where the starfield moves against the scroll direction
                        const yOffset = -100 * scrollFraction;
                        twinkling.style.backgroundPositionY = `${yOffset}px`;
                    }
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>