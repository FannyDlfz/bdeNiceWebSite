<!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <title>@section('title')BDE Nice@endsection</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{asset('/vendors/bootstrap/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('/css/style.css')}}">
    </head>
    <body>

        <header class="topnav">
                <div>
                    <a><img src="{{asset('/img/logo.png')}}" style="height: 75px;" alt="BDE Nice"/></a>
                    <a href="{{ route('home') }}">Accueil</a>
                    <a href="{{ route('articles.index') }}">Boutique</a>
                    <a href="{{ route('events.index') }}">Evènements</a>
                </div>
                <div class="topnav-right">
                    <a><img src="{{asset('/img/avatar.png')}}" style="height: 40px;" alt="Connection"/></a>
                    @if(session()->has('user'))
                        <a href="/users/{{ session('user') }}/edit">Mon profil</a>
                        <a href="{{route('basket.show', session('user'))}}">Mon panier</a>
                        @if(session('role') > 1)
                            <a href="{{ route('admin') }}">Admin</a>
                        @endif
                        <a href="{{ route('logout') }}">Déconnexion</a>
                    @else
                        <a href="{{route('login')}}">Connexion</a>
                        <a href="{{route('users.create')}}">Inscription</a>
                    @endif
                </div>
        </header>

        <main>
            @yield('content')

            <div class="alert alert-dismissible text-center cookiealert" role="alert">
                <div class="cookiealert-container">
                    <b>Aimez-vous les cookies ?</b> &#x1F36A; Nous utilisons les cookies pour vous assurer une meilleure expérience sur notre site. <a href="http://cookiesandyou.com/" target="_blank">Ensavoir plus</a>

                    <button type="button" class="btn btn-primary btn-sm acceptcookies" aria-label="Close">
                        J'accepte
                    </button>
                </div>
            </div>

        </main>
        @yield('scripts')
        <script src="{{asset('/js/Cookies.js')}}"></script>
    </body>
</html>
