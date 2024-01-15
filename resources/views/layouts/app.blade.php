<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/main.sass', 'resources/js/app.js'])
</head>
<body>
    <header>
        {{-- <p >barre de recherche</p> --}}
        <a href="{{ url('/') }}" class="header__title">
            
            <h1>L'Étoffe Enchantée</h1>
        </a>
        
        <nav class="header__nav">
            <!-- Authentication Links -->
            @guest
                @if (Route::has('login'))
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                @endif

                @if (Route::has('register'))
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                @endif
            @else
                @if(Auth::user()->role_id == 2)
                    <a href="{{route('admin.index')}}"><img src="/icons/set-up.svg" alt="Espace administration" class="header__icon"/></a>
                @endif


                <a href="{{route('orders.show', $orderCart)}}"><img src="/icons/cart.svg" alt="Accéder à mon panier" class="header__icon"/></a>
                <a href="{{route('utilisateur.index', $user=Auth::user())}}"><img src="/icons/personal.svg" alt="mon compte" class="header__icon"/></a>
                <a class="" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                    <img src="/icons/switch.svg" alt="Se déconnecter" class="header__icon"/>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                </form>
            @endguest
        </nav>

    </header>
    

    <div id="app">
        

        <main>
            <div class="container-fluid text-center" id="tempMessage">
                @if(session()->has('message'))
                    <p class="alert alert-success">{{session()->get('message')}}</p>
                @endif

                @if($errors->any())
                    @foreach($errors->all() as $error)
                        <p class="alert alert-danger">{{$error}}</p>
                    @endforeach
                @endif
            </div>
            @yield('content')
        </main>
    </div>

    <script src="{{asset('js/modal.js')}}"></script>
    <script>
        setTimeout(() => {
            document.getElementById('tempMessage').classList.add('hidden')
        }, 4000);
    </script>
</body>
</html>
