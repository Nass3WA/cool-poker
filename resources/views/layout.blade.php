<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Cool Poker - @yield('title')</title>
        <!-- CSS SHEET -->

        <link rel="stylesheet" href="{{mix('css/app.css')}}">

        <!-- FONT AWESOME CDN -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
        <script src="https://kit.fontawesome.com/ba0f3fbf00.js" crossorigin="anonymous"></script>
    </head>

    <body>
    <header>
        <a href="{{ route('homepage') }}"><i class="fas fa-caravan"></i></a>
        <nav>
            <ul class="container">
                <li><a href="{{ route('homepage') }}">Accueil</a></li>
                <!--Affichage des menus uniquement que si l'utilisateur est connecté-->
                @auth
                    <li><a href="{{ route('users.edit') }}">Modifier son profil</a></li>
                    <li><a href="{{ route('users.logout') }}">Se déconnecter</a></li>
                @else
                    <li><a href="{{ route('users.create') }}">Créer un compte</a></li>
                    <li><a href="{{ route('users.login') }}">Se connecter</a></li>
                @endauth
            </ul>
        </nav>
    </header>

    <main class="container">
        @if (session('status') AND session('message'))
            <div class="alert alert-{{session('status')}}">
                {{ session('message') }}
            </div>
        @endif

        @yield('content')
    </main>

    <script src="{{mix('js/app.js')}}"></script>

    </body>
</html>
