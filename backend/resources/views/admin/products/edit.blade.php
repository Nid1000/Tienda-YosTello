@extends('layouts.admin', ['title' => 'YO-TELLO | Editar Producto'])

@section('content')
    <section class="section compact">
        <div class="container auth-shell">
            <div class="auth-card wide-card">
                <p class="eyebrow">Administrador</p>
                <h1>Editar producto</h1>
                @include('admin.products.partials.form', [
                    'action' => route('admin.productos.update', $product),
                    'method' => 'PUT',
                    'product' => $product,
                    'categories' => $categories,
                ])
            </div>
        </div>
    </section>
@endsection
