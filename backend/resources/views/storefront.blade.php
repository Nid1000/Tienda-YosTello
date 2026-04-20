<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="api-base-url" content="{{ url('/api') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @auth
        <meta name="auth-user-initial" content="{{ mb_substr(auth()->user()->name, 0, 1) }}">
        <meta name="auth-user-name" content="{{ auth()->user()->name }}">
        <meta name="logout-url" content="{{ route('logout') }}">
    @endauth
    <title>YO-TELLO</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('yotello-mark.svg') }}">
    <link rel="shortcut icon" href="{{ asset('yotello-mark.svg') }}">
    @php
        $js = collect(glob(public_path('assets/index-*.js')))
            ->sortByDesc(fn ($path) => filemtime($path))
            ->map(fn ($path) => '/assets/'.basename($path))
            ->first();
        $css = collect(glob(public_path('assets/index-*.css')))
            ->sortByDesc(fn ($path) => filemtime($path))
            ->map(fn ($path) => '/assets/'.basename($path))
            ->first();
    @endphp
    @if ($js)
        <script type="module" crossorigin src="{{ $js }}"></script>
    @endif
    @if ($css)
        <link rel="stylesheet" crossorigin href="{{ $css }}">
    @endif
</head>
<body>
    <div id="app"></div>
</body>
</html>
