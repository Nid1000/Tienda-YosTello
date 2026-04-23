<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'YO-TELLO | Tienda de ropa' }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('yotello-mark.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <main class="auth-brand-shell">
        <section class="auth-brand-panel">
            <a class="auth-brand-mark" href="{{ route('home') }}">
                <img src="{{ asset('yotello-mark.svg') }}" alt="YO-TELLO">
                <span>YO-TELLO</span>
            </a>
            <div class="auth-brand-copy">
                <p class="eyebrow">Tienda de ropa</p>
                <h1>Moda urbana, zapatillas y prendas esenciales.</h1>
                <p>Ingresa para comprar, revisar pedidos y continuar tu experiencia YO-TELLO.</p>
            </div>
        </section>

        <section class="auth-card">
            {{ $slot }}
        </section>
    </main>
</body>
</html>
