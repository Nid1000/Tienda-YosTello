<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'YO-TELLO Admin' }}</title>
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
<body class="admin-body">
    <header class="admin-only-header">
        <a class="admin-only-brand" href="{{ route('admin.index') }}">YO-TELLO Admin</a>
        <nav class="admin-only-links">
            <a href="{{ route('home') }}">Ver tienda</a>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button class="nav-button" type="submit">Salir</button>
            </form>
        </nav>
    </header>

    <main class="admin-shell">
        <aside class="admin-sidebar">
            <div class="admin-brand-card">
                <img class="admin-avatar" src="{{ asset('yotello-mark.svg') }}" alt="YO-TELLO">
                <div>
                    <strong>Panel Admin</strong>
                    <span>{{ auth()->user()?->email ?? 'admin@yotello.com' }}</span>
                </div>
            </div>

            <nav class="admin-nav">
                <a class="{{ request()->routeIs('admin.index') ? 'active' : '' }}" href="{{ route('admin.index') }}">Dashboard</a>
                <a class="{{ request()->routeIs('admin.productos.*') ? 'active' : '' }}" href="{{ route('admin.productos.index') }}">Productos</a>
                <a class="{{ request()->routeIs('admin.categorias.*') ? 'active' : '' }}" href="{{ route('admin.categorias.index') }}">Categorias</a>
                <a class="{{ request()->routeIs('admin.promociones.*') ? 'active' : '' }}" href="{{ route('admin.promociones.index') }}">Promociones</a>
                <a class="{{ request()->routeIs('admin.pedidos.*') ? 'active' : '' }}" href="{{ route('admin.pedidos.index') }}">Pedidos</a>
                <a class="{{ request()->routeIs('admin.usuarios.*') ? 'active' : '' }}" href="{{ route('admin.usuarios.index') }}">Usuarios</a>
                <a href="{{ route('home') }}">Ver tienda</a>
            </nav>
        </aside>

        <div class="admin-main">
            @if (session('status'))
                <div class="flash success">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="flash error">
                    <p>Revisa los datos ingresados.</p>
                </div>
            @endif

            @yield('content')
        </div>
    </main>
</body>
</html>
