<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Forum de discussion')</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
            color: #333;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }
        
        /* Header styles */
        header {
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 15px 0;
            margin-bottom: 20px;
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .forum-title {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
        }
        
        .search-bar {
            display: flex;
            align-items: center;
            background-color: #f0f2f5;
            border-radius: 20px;
            padding: 8px 15px;
            width: 300px;
        }
        
        .search-bar input {
            background: transparent;
            border: none;
            outline: none;
            width: 100%;
            margin-left: 8px;
            font-size: 14px;
        }
        
        .search-bar input::placeholder {
            color: #65676b;
        }
        
        .nav-links {
            display: flex;
            gap: 20px;
        }
        
        .nav-links a {
            text-decoration: none;
            color: #2c3e50;
            font-weight: 500;
            padding: 5px 10px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }
        
        .nav-links a:hover {
            background-color: #f0f2f5;
        }
        
        .nav-links a.active {
            color: #1877f2;
            background-color: #e7f3ff;
        }
        
        /* Main content area */
        .main-content {
            display: flex;
            gap: 20px;
            min-height: 70vh;
        }
        
        .sidebar {
            width: 250px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            padding: 20px;
        }
        
        .sidebar h3 {
            margin-bottom: 15px;
            color: #2c3e50;
            font-size: 18px;
        }
        
        .sidebar ul {
            list-style: none;
        }
        
        .sidebar li {
            margin-bottom: 10px;
        }
        
        .sidebar a {
            text-decoration: none;
            color: #4a5568;
            display: block;
            padding: 8px 10px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }
        
        .sidebar a:hover {
            background-color: #f7fafc;
        }
        
        .content {
            flex: 1;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            padding: 20px;
        }
        
        .content h1 {
            margin-bottom: 20px;
            color: #2c3e50;
            font-size: 24px;
        }
        
        /* Forum topics */
        .topic {
            border-bottom: 1px solid #e2e8f0;
            padding: 15px 0;
        }
        
        .topic:last-child {
            border-bottom: none;
        }
        
        .topic-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .topic-title a {
            text-decoration: none;
            color: #2c3e50;
        }
        
        .topic-meta {
            color: #718096;
            font-size: 14px;
        }
        
        /* Footer */
        footer {
            margin-top: 30px;
            padding: 20px 0;
            text-align: center;
            color: #718096;
            font-size: 14px;
            border-top: 1px solid #e2e8f0;
        }

        .login-btn {
            background-color: #1877f2;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
            text-decoration: none;
            display: inline-block;
        }
        
        .login-btn:hover {
            background-color: #166fe5;
        }

        /* Styles pour la pagination */
        .pagination {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 0;
        }

        .pagination li {
            margin: 0 5px;
        }

        .pagination a, .pagination span {
            display: inline-block;
            padding: 8px 16px;
            text-decoration: none;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            color: #4a5568;
            transition: all 0.2s;
        }

        .pagination a:hover {
            background-color: #f7fafc;
            border-color: #cbd5e0;
        }

        .pagination .active span {
            background-color: #1877f2;
            color: white;
            border-color: #1877f2;
        }

        .pagination .disabled span {
            color: #a0aec0;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <div class="forum-title">ComVtuber</div>
                <div class="search-bar">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="#65676b">
                        <path d="M10.25 2a8.25 8.25 0 0 1 6.34 13.53l5.69 5.69a.75.75 0 1 1-1.06 1.06l-5.69-5.69A8.25 8.25 0 1 1 10.25 2zm0 1.5a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5z"></path>
                    </svg>
                    <input type="text" placeholder="Rechercher un sujet...">
                </div>
                <div class="nav-links">
                    <a href="{{ route('home') }}" class="active">Accueil</a>
                    <a href="#">Articles</a>
                    <a href="#">Vtubers</a>
                </div>
                <a href="#" class="login-btn">Connexion</a>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="main-content">
            <!-- Sidebar optionnelle -->
            <aside class="sidebar">
                <h3>Catégories</h3>
                <ul>
                    <li><a href="#">Tous les articles</a></li>
                    <li><a href="#">Populaires</a></li>
                    <li><a href="#">Récents</a></li>
                    <li><a href="#">Favoris</a></li>
                </ul>
            </aside>

            <!-- Contenu principal -->
            <main class="content">
                @yield('content')
            </main>
        </div>
    </div>

    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} ComVtuber. Tous droits réservés.</p>
        </div>
    </footer>
</body>
</html>