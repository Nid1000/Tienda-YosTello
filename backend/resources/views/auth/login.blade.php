@extends('layouts.app', ['title' => 'YO-TELLO | Login'])

@section('content')
    <section class="section compact">
        <div class="container auth-shell">
            <div class="auth-card">
                <p class="eyebrow">Acceso clientes</p>
                <h1>Ingresa a tu cuenta</h1>
                <p class="lead compact-lead">Este inicio es solo para clientes: compras, carrito y pedidos.</p>
                <form method="POST" action="{{ route('login') }}" class="stack-form">
                    @csrf
                    <label>
                        <span>Email</span>
                        <input type="email" name="email" value="{{ old('email') }}" required>
                    </label>
                    <label>
                        <span>Contrasena</span>
                        <input type="password" name="password" required>
                    </label>
                    <label class="check-row">
                        <input type="checkbox" name="remember" value="1">
                        <span>Recordarme</span>
                    </label>
                    <button class="button primary" type="submit">Entrar como cliente</button>
                </form>
                <p class="auth-footer">
                    No tienes cuenta?
                    <a href="{{ route('register') }}">Crear cuenta</a>
                </p>
            </div>
        </div>
    </section>
@endsection
