<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'YO-TELLO' }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('yotello-mark.svg') }}">
    <link rel="shortcut icon" href="{{ asset('yotello-mark.svg') }}">
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
    @php
        $cartCount = collect(session('cart', []))->sum('quantity');
    @endphp
    <header class="site-header">
        <div class="container nav">
            <a class="brand" href="{{ route('home') }}">YO-TELLO</a>
            <nav class="nav-links">
                <a href="{{ route('home') }}">Inicio</a>
                <a href="{{ route('products.index') }}">Catalogo</a>
                @auth
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.index') }}">Panel admin</a>
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button class="nav-button" type="submit">Salir</button>
                        </form>
                    @else
                        <a href="{{ route('cart.index') }}" class="cart-link">
                            Carrito
                            @if ($cartCount > 0)
                                <span class="cart-badge">{{ $cartCount }}</span>
                            @endif
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="nav-button" type="submit">Salir</button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Registro</a>
                @endauth
            </nav>
        </div>
    </header>

    <main>
        @if (session('status'))
            <div class="container flash success">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="container flash error">
                <p>Corrige los campos marcados para continuar.</p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="container footer-grid">
            <div>
                <h3>YO-TELLO</h3>
                <p>Moda urbana con una experiencia de inicio, carrito y pedidos mas viva y accionable.</p>
            </div>
            <div>
                <h4>Compra</h4>
                <ul>
                    <li>Catalogo conectado</li>
                    <li>Carrito y checkout</li>
                    <li>Seguimiento de pedidos</li>
                </ul>
            </div>
            <div>
                <h4>Contacto</h4>
                <p>ventas@novawear.test</p>
                <p>+57 300 000 0000</p>
            </div>
        </div>
    </footer>
</body>
</html>
