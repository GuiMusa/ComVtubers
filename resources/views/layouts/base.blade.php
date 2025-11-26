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
        
        /* --- SCROLL TO TOP BUTTON --- */
        .back-to-top-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--theme-secondary), #ffc478);
            color: white;
            border: none;
            border-radius: 50%;
            font-size: 1.5rem;
            cursor: pointer;
            display: none;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(255, 179, 71, 0.4);
            transition: all 0.3s ease;
            z-index: 1000;
        }
        
        .back-to-top-btn:hover {
            background: linear-gradient(135deg, var(--theme-primary), #ff9aa2);
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(255, 182, 193, 0.5);
        }
        
        .back-to-top-btn.show {
            display: flex;
            animation: fadeIn 0.3s ease-in-out;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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
        
        /* Custom "Lire la suite" button */
        .btn-read-more {
            display: inline-flex;
            align-items: center;
            padding: 12px 24px;
            background: linear-gradient(135deg, var(--theme-primary), #ff9aa2);
            color: white;
            text-decoration: none;
            font-weight: 600;
            border-radius: 25px;
            box-shadow: 0 4px 15px rgba(255, 182, 193, 0.3);
            transition: all 0.3s ease;
        }
        
        .btn-read-more:hover {
            background: linear-gradient(135deg, #ff9aa2, var(--theme-primary));
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 182, 193, 0.4);
        }
        
        .btn-read-more i {
            transition: transform 0.3s ease;
        }
        
        .btn-read-more:hover i {
            transform: translateX(5px);
        }
        
        /* Article page action buttons */
        .btn-back {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            background: rgba(161, 136, 127, 0.1);
            color: var(--theme-text);
            text-decoration: none;
            font-weight: 600;
            border-radius: 25px;
            border: 2px solid var(--theme-text-muted);
            transition: all 0.3s ease;
        }
        
        .btn-back:hover {
            background: var(--theme-text-muted);
            color: white;
            border-color: var(--theme-text-muted);
            transform: translateX(-5px);
        }
        
        .btn-edit-article,
        .btn-delete-article {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 150px;
            height: 42px;
            padding: 10px 20px;
            color: white;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            border-radius: 25px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
        }
        
        .btn-edit-article {
            background: linear-gradient(135deg, #9d4edd, #b794f6);
            box-shadow: 0 3px 12px rgba(157, 78, 221, 0.3);
        }
        
        .btn-edit-article:hover {
            background: linear-gradient(135deg, #b794f6, #9d4edd);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 18px rgba(157, 78, 221, 0.4);
        }
        
        .btn-delete-article {
            background: linear-gradient(135deg, #dc3545, #e63946);
            box-shadow: 0 3px 12px rgba(220, 53, 69, 0.3);
        }
        
        .btn-delete-article:hover {
            background: linear-gradient(135deg, #e63946, #dc3545);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 18px rgba(220, 53, 69, 0.4);
        }
        
        /* Removed .article-card .btn-primary override - using global button styles */
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

        /* === GLOBAL BUTTON STYLES === */
        .btn-primary {
            background: linear-gradient(135deg, var(--theme-primary), #ff9aa2);
            border: none;
            color: #fff;
            font-weight: 600;
            border-radius: 25px;
            padding: 10px 20px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 182, 193, 0.3);
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #ff9aa2, var(--theme-primary));
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 182, 193, 0.4);
        }
        
        .btn-secondary {
            background: var(--theme-text-muted);
            border: none;
            color: #fff;
            font-weight: 600;
            border-radius: 25px;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }
        .btn-secondary:hover {
            background: var(--theme-text);
            color: #fff;
            transform: translateY(-2px);
        }
        
        .btn-success {
            background: linear-gradient(135deg, #28a745, #34c759);
            border: none;
            color: #fff;
            font-weight: 600;
            border-radius: 25px;
            padding: 10px 20px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }
        .btn-success:hover {
            background: linear-gradient(135deg, #34c759, #28a745);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
        }
        
        .btn-outline-primary {
            background: transparent;
            border: 2px solid var(--theme-primary);
            color: var(--theme-primary);
            font-weight: 600;
            border-radius: 25px;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }
        .btn-outline-primary:hover {
            background: var(--theme-primary);
            color: #fff;
            transform: translateY(-2px);
        }
        
        .btn-outline-secondary {
            background: transparent;
            border: 2px solid var(--theme-text-muted);
            color: var(--theme-text-muted);
            font-weight: 600;
            border-radius: 25px;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }
        .btn-outline-secondary:hover {
            background: var(--theme-text-muted);
            color: #fff;
        }
        
        .btn-outline-danger {
            background: transparent;
            border: 2px solid #dc3545;
            color: #dc3545;
            font-weight: 600;
            border-radius: 25px;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }
        .btn-outline-danger:hover {
            background: #dc3545;
            color: #fff;
            transform: translateY(-2px);
        }
        
        /* Small buttons */
        .btn-sm {
            padding: 6px 14px;
            font-size: 0.85rem;
        }
        
        .btn-lg {
            padding: 14px 28px;
            font-size: 1.1rem;
        }

        /* --- SIDEBARS (cleaned up) --- */
        hr {
            border-color: var(--theme-glow);
        }

        /* === NEW SIDEBAR STYLES === */
        .sidebar-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 4px 20px rgba(93, 64, 55, 0.1);
            margin-bottom: 1.5rem;
        }
        
        .sidebar-title {
            font-family: var(--font-heading);
            font-size: 1.1rem;
            color: var(--theme-text);
            padding-bottom: 12px;
            margin-bottom: 15px;
            border-bottom: 2px solid var(--theme-primary);
            display: flex;
            align-items: center;
        }
        
        .sidebar-section {
            margin-bottom: 8px;
        }
        
        .sidebar-toggle {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 12px;
            background: transparent;
            border: none;
            border-radius: 8px;
            color: var(--theme-text);
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .sidebar-toggle:hover {
            background: rgba(255, 182, 193, 0.15);
            color: var(--theme-primary);
        }
        
        .sidebar-toggle .toggle-icon {
            transition: transform 0.3s ease;
        }
        
        .sidebar-toggle[aria-expanded="true"] .toggle-icon {
            transform: rotate(180deg);
        }
        
        .sidebar-list {
            list-style: none;
            padding: 5px 0 10px 15px;
            margin: 0;
        }
        
        .sidebar-list li {
            padding: 6px 10px;
            border-radius: 6px;
            transition: background 0.2s;
        }
        
        .sidebar-list li:hover {
            background: rgba(255, 182, 193, 0.1);
        }
        
        .sidebar-list a {
            color: var(--theme-text-muted);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.2s;
        }
        
        .sidebar-list a:hover {
            color: var(--theme-primary);
        }
        
        .sidebar-list .text-muted {
            font-size: 0.85rem;
            font-style: italic;
        }

        /* === RIGHT SIDEBAR - RECOMMENDED === */
        .recommended-articles {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        
        .recommended-card {
            display: flex;
            gap: 12px;
            padding: 10px;
            background: var(--theme-bg);
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }
        
        .recommended-card:hover {
            transform: translateX(5px);
            border-color: var(--theme-primary);
            box-shadow: 0 4px 12px rgba(255, 182, 193, 0.2);
        }
        
        .recommended-image {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            overflow: hidden;
            flex-shrink: 0;
        }
        
        .recommended-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .recommended-placeholder {
            background: linear-gradient(135deg, var(--theme-primary), var(--theme-secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }
        
        .recommended-content {
            flex: 1;
            min-width: 0;
        }
        
        .recommended-title {
            font-family: var(--font-heading);
            font-size: 0.95rem;
            color: var(--theme-text);
            margin: 0 0 5px 0;
            line-height: 1.3;
        }
        
        .recommended-meta {
            font-size: 0.8rem;
            color: var(--theme-text-muted);
            margin: 0;
        }
        
        .empty-recommendations {
            text-align: center;
            padding: 30px 20px;
            color: var(--theme-text-muted);
        }
        
        .empty-recommendations i {
            font-size: 2.5rem;
            display: block;
            margin-bottom: 10px;
            opacity: 0.5;
        }

        /* === COMMENTS SECTION STYLES === */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(93, 64, 55, 0.1);
        }
        
        .card-header {
            background: linear-gradient(135deg, rgba(255, 182, 193, 0.1), rgba(255, 179, 71, 0.1)) !important;
            border-bottom: 1px solid var(--theme-glow);
            border-radius: 12px 12px 0 0 !important;
        }
        
        .comment {
            border-left: 3px solid var(--theme-primary);
            transition: all 0.3s ease;
        }
        
        .comment:hover {
            border-left-color: var(--theme-secondary);
            background: rgba(255, 255, 255, 0.8) !important;
        }
        
        .mention {
            border-left: 3px solid var(--theme-secondary);
        }
        
        /* Form controls in comments */
        .form-control:focus {
            border-color: var(--theme-primary);
            box-shadow: 0 0 0 3px rgba(255, 182, 193, 0.25);
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
            <div class="footer-copyright">
                <p>&copy; {{ date('Y') }} ComVtuber. Un univers de créativité.</p>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="back-to-top" class="back-to-top-btn" title="Retour en haut">
        <i class="bi bi-arrow-up"></i>
    </button>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Back to top button
            const backToTopBtn = document.getElementById("back-to-top");
            if(backToTopBtn) {
                // Show/hide button on scroll
                window.addEventListener('scroll', function() {
                    if (window.pageYOffset > 300) {
                        backToTopBtn.classList.add('show');
                    } else {
                        backToTopBtn.classList.remove('show');
                    }
                });
                
                // Smooth scroll to top on click
                backToTopBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
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