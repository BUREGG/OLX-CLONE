<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OLX CLONE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <style>

    </style>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">

        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">OLX CLONE</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a href="{{ url('/product') }}" class="btn btn-primary">Pokaz wszystkie ogłoszenia</a>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                   
                    @if(auth()->check())

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('favorite') ? 'fw-bold' : '' }}" aria-current="page" href="{{ url('/favorite') }}">Ulubione</a>
                    </li>
                    @endif
                    @if(auth()->check())

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('chat') ? 'fw-bold' : '' }}" href="{{ url('conversations') }}">Wiadomosci</a>
                    </li>
                    @endif
                    @if(auth()->check())

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('myaccount') ? 'fw-bold' : '' }}" href="{{ url('myaccount') }}">Moje konto</a>
                    </li>
                    @endif
                    @if(auth()->check())
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('addproduct') ? 'fw-bold' : '' }}" href="{{ url('addproduct') }}">Dodaj ogłoszenie</a>
                    </li>
                    @endif
                    @if(!auth()->check())

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('login') ? 'fw-bold' : '' }}" href="{{ route('login') }}">Zaloguj</a>
                    </li>
                    @endif
                    @if(auth()->check())
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('logout') ? 'fw-bold' : '' }}" href="{{ route('logout') }}">Wyloguj</a>
                    </li>
                    @endif
                    @role ('super-admin')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('permissions') ? 'fw-bold' : '' }}" aria-current="page"
                            href="{{ url('/permissions') }}">Panel admina</a>
                    </li>
                     @endrole
                </ul>

                @auth
                    <span class="navbar-text" style="margin-right: 5px">
                        Zalogowany jako: {{ auth()->user()->name }}
                    </span>
                @endauth
                <form class="d-flex" role="search" action="{{route('products.search')}}" method="GET">
                    <input class="form-control me-2" type="search" placeholder="Search" name="search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>

            </div>
        </div>
    </nav>

    @yield('content')
  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
</body>

</html>
