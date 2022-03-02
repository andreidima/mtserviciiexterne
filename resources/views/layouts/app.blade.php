<!doctype html>
<html class="h-100" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/andrei.css') }}" rel="stylesheet">

    <!-- Font Awesome links -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</head>
<body class="d-flex flex-column h-100">
    @auth
    {{-- <div id="app"> --}}
    <header>
        <nav class="navbar navbar-lg navbar-expand-lg navbar-dark shadow-sm" style="background-color: darkcyan">
            <div class="container">
                <a class="navbar-brand me-5" href="{{ url('/') }}">
                    MT
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>


                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        @if (auth()->user()->name === "Andrei Dima" || auth()->user()->name === "MT Servicii Externe")
                            <li class="nav-item me-3 dropdown">
                                <a class="nav-link active dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-file-alt me-1"></i>
                                    SSM
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a class="dropdown-item" href="/ssm/firme">
                                            Administrare
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="/rapoarte/ssm">
                                            Raport
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item me-3 dropdown">
                                <a class="nav-link active dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-clinic-medical me-1"></i>
                                    Medicina muncii
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a class="dropdown-item" href="/medicina-muncii/firme">
                                            Administrare
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="/rapoarte/medicina-muncii">
                                            Raport
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="/rapoarte/medicina-muncii/nr-de-inregistrare">
                                            Nr de înregistrare
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item me-3 dropdown">
                                <a class="nav-link active dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-fire-extinguisher me-1"></i>
                                    Stingătoare și hidranți
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a class="dropdown-item" href="/stingatoare/firme">
                                            Administrare
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="/rapoarte/stingatoare">
                                            Raport stingătoare
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="/rapoarte/hidranti">
                                            Raport hidranți
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item me-3 dropdown">
                                <a class="nav-link active dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-route me-1"></i>
                                    Trasee
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a class="dropdown-item" href="/ssm/firme/trasee">
                                            Trasee SSM
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/stingatoare/firme/trasee">
                                            Trasee stingătoare
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item me-3 dropdown">
                                <a class="nav-link active dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-file-pdf me-1"></i>
                                    Tematici
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a class="dropdown-item" href="/tematici">
                                            Lista de tematici
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="/tematici/firme-tematici">
                                            Firme - tematici
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="/tematici/salariati-tematici">
                                            Salariați - tematici
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item me-3">
                                <a class="nav-link active" href="/observatii">
                                    <i class="fas fa-comments"></i>
                                    Observații
                                </a>
                            </li>
                        @elseif (auth()->user()->name === "SSM")
                            <li class="nav-item me-3">
                                <a class="nav-link active" href="/ssm/firme">
                                    <i class="fas fa-building me-1"></i>
                                    Administrare
                                </a>
                            </li>
                            {{-- <li class="nav-item me-3">
                                <a class="nav-link active" href="/rapoarte/ssm">
                                    <i class="fas fa-file-alt me-1"></i>
                                    Raport
                                </a>
                            </li>
                            <li class="nav-item me-3">
                                <a class="nav-link active" href="/ssm/firme/trasee">
                                    <i class="fas fa-route"></i>
                                    Trasee
                                </a>
                            </li> --}}
                        @elseif (auth()->user()->name === "Medicina Muncii")
                            <li class="nav-item me-3">
                                <a class="nav-link active" href="/medicina-muncii/firme">
                                    Administrare
                                </a>
                            </li>
                            <li class="nav-item me-3">
                                <a class="nav-link active" href="/rapoarte/medicina-muncii">
                                    Raport
                                </a>
                            </li>
                            <li class="nav-item me-3">
                                <a class="nav-link active" href="/rapoarte/medicina-muncii/nr-de-inregistrare">
                                    Nr de înregistrare
                                </a>
                            </li>
                        @elseif (auth()->user()->name === "Stingatoare")
                            <li class="nav-item me-3">
                                <a class="nav-link active" href="/stingatoare/firme">
                                    Administrare
                                </a>
                            </li>
                            <li class="nav-item me-3">
                                <a class="nav-link active" href="/rapoarte/stingatoare">
                                    Raport stingătoare
                                </a>
                            </li>
                            <li class="nav-item me-3">
                                <a class="nav-link active" href="/rapoarte/hidranti">
                                    Raport hidranți
                                </a>
                            </li>
                            <li class="nav-item me-3">
                                <a class="nav-link active" href="/stingatoare/firme/trasee">
                                    <i class="fas fa-route"></i>
                                    Trasee
                                </a>
                            </li>
                        @endif
                    </ul>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link active dropdown-toggle" href="#" id="navbarAuthentication" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </a>

                                <ul class="dropdown-menu" aria-labelledby="navbarAuthentication">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    @endauth

    <main class="flex-shrink-0 py-4">
        @yield('content')
    </main>

    {{-- <footer class="mt-auto py-3 bg-light text-center">
        <div class="">
            <span class="text-muted border-top">
                <a href="https://validsoftware.ro/dezvoltare-aplicatii-web-personalizate/" target="_blank">
                    Aplicație web</a>
                dezvoltată de
                <a href="https://validsoftware.ro/" target="_blank">
                    validsoftware.ro
                </a>
            </span>
        </div>
    </footer> --}}
</body>
</html>
