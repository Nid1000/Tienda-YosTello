<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'YO-TELLO') }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('yotello-mark.svg') }}">
    @php
        $hasViteAssets = file_exists(public_path('hot')) || file_exists(public_path('build/manifest.json'));
    @endphp
    @if ($hasViteAssets)
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link rel="stylesheet" href="{{ url('/app.css') }}">
        <script defer src="{{ url('/app.js') }}"></script>
    @endif
</head>
<body>
    <header class="site-header">
        <nav class="container nav">
            <a class="brand" href="{{ route('home') }}">YO-TELLO</a>
            <div class="nav-links">
                <a href="{{ route('products.index') }}">Catalogo</a>
                @auth
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.index') }}">Admin</a>
                    @else
                        <a href="{{ route('cart.index') }}">Carrito</a>
                        <a href="{{ route('orders.index') }}">Pedidos</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="nav-button" type="submit">Salir</button>
                    </form>
                @else
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Registro</a>
                @endauth
            </div>
        </nav>
    </header>

    @if (session('status'))
        <div class="container">
            <div class="flash success">{{ session('status') }}</div>
        </div>
    @endif

    @if ($errors->any())
        <div class="container">
            <div class="flash error">
                <p>Revisa los datos ingresados.</p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    @hasSection('content')
        @yield('content')
    @else
        <main>
            {{ $slot ?? '' }}
        </main>
    @endif
</body>
</html>
