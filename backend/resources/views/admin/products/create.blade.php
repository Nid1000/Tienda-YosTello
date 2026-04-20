@extends('layouts.admin', ['title' => 'YO-TELLO | Nuevo Producto'])

@section('content')
    <section class="section compact">
        <div class="container auth-shell">
            <div class="auth-card wide-card">
                <p class="eyebrow">Administrador</p>
                <h1>Crear producto</h1>
                @include('admin.products.partials.form', [
                    'action' => route('admin.productos.store'),
                    'method' => 'POST',
                    'product' => null,
                    'categories' => $categories,
                ])
            </div>
        </div>
    </section>
@endsection
