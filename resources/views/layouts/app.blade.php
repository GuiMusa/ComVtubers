<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Forum de discussion')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #f5f5f5;
        }
        #back-to-top {
            position: fixed;
            bottom: 25px;
            right: 25px;
            display: none;
            z-index: 99;
            width: 50px;
            height: 50px;
            text-align: center;
            line-height: 1.9;
            font-size: 1.5rem;
        }

        /* Nouveau style pour la flèche (triangle CSS) */
        .arrow-indicator {
            border: solid black;
            border-width: 0 2px 2px 0;
            display: inline-block;
            padding: 3px;
            transform: rotate(-45deg); /* Flèche pointant vers la droite */
            -webkit-transform: rotate(-45deg);
            transition: transform 0.3s ease;
        }

/* Cible le lien lorsque le menu est déplié */
a[aria-expanded="true"] .arrow-indicator {
    transform: rotate(45deg); /* Fait pivoter la flèche vers le bas */
    -webkit-transform: rotate(45deg);
}

    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    <header class="bg-white shadow-sm py-3">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <a class="fs-4 fw-bold text-dark text-decoration-none" href="{{ route('home') }}">ComVtuber</a>
                <form class="d-flex" style="width: 300px;">
                    <input class="form-control me-2" type="search" placeholder="Rechercher un sujet..." aria-label="Search">
                </form>
                <ul class="nav nav-pills">
                    <li class="nav-item"><a href="{{ route('home') }}" class="nav-link active" aria-current="page">Accueil</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Articles</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Vtubers</a></li>
                </ul>
                <a href="#" class="btn btn-primary">Connexion</a>
            </div>
        </div>
    </header>

    <div class="container mt-4">
        <div class="row">
            @yield('content-with-sidebar')
        </div>
    </div>

    <footer class="mt-auto py-3 text-center text-muted border-top bg-white">
        <div class="container">
            <p>&copy; {{ date('Y') }} ComVtuber. Tous droits réservés.</p>
        </div>
    </footer>

    <!-- Bouton Back to Top -->
    <a href="#" id="back-to-top" class="btn btn-primary rounded-circle shadow">
        &uarr;
    </a>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        let mybutton = document.getElementById("back-to-top");

        window.onscroll = function() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                mybutton.style.display = "block";
            } else {
                mybutton.style.display = "none";
            }
        };

        mybutton.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    </script>
</body>
</html>