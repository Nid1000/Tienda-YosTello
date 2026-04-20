@extends('layouts.app', ['title' => 'YO-TELLO | Mi cuenta'])

@section('content')
    <section class="section compact">
        <div class="container dashboard-grid">
            <div class="panel-card">
                <p class="eyebrow">Perfil</p>
                <h1>Hola, {{ $user->name }}</h1>
                <p>{{ $user->email }}</p>
                <p>Rol: {{ $user->isAdmin() ? 'Administrador' : 'Cliente' }}</p>
                <div class="hero-actions">
                    <a class="button primary" href="{{ route('products.index') }}">Seguir comprando</a>
                    <a class="button secondary" href="{{ route('orders.index') }}">Ver pedidos</a>
                </div>
            </div>

            <div class="panel-card">
                <p class="eyebrow">Actividad</p>
                <h2>Ultimos pedidos</h2>
                @forelse ($orders as $order)
                    <div class="mini-order">
                        <strong>Pedido #{{ $order->id }}</strong>
                        <span>{{ $order->status }}</span>
                        <span>S/. {{ number_format($order->total, 2, '.', ',') }}</span>
                    </div>
                @empty
                    <p>Aun no tienes pedidos registrados.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
