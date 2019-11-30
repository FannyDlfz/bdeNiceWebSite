<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Administration</title>

        <!-- CSS -->
        <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    </head>

    <body>
        <header class="header">
            <div class="orange-bar">
                <p id="inside-bar">@yield('title')</p>
                <form class="search-bar" action="">
                    <input placeholder="Rechercher..." class="fas fa-search"><button type="submit" class='fas'>&#xf002;</button>
                </form>

            </div>
        </header>
        <nav class="sidenav">
            <div class="side-nav-title">
                <img src="{{ asset('img/logo.png') }}" alt="logo">
                <h2>Administration</h2>
            </div>
            <a href="/admin/"> <i class="fas fa-circle"></i>Panneau de contrôle</a>
            <a href="/admin/events"> <i class="fas fa-calendar-day"></i>Evènements</a>
            <a href="/admin/articles"> <i class="fas fa-user"></i>Articles</a>
        </nav>
        <main>

            @yield('content')

        </main>

        <script src='https://kit.fontawesome.com/a076d05399.js'></script>
        @yield('scripts')

    </body>



</html>
