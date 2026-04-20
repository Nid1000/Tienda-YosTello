@extends('layouts.admin', ['title' => 'YO-TELLO | Nueva Promocion'])

@section('content')
    <section class="section compact">
        <div class="container auth-shell">
            <div class="auth-card wide-card">
                <p class="eyebrow">Administrador</p>
                <h1>Nueva promocion</h1>
                @include('admin.promotions.partials.form', [
                    'action' => route('admin.promociones.store'),
                    'method' => 'POST',
                    'promotion' => null,
                    'categories' => $categories,
                    'products' => $products,
                ])
            </div>
        </div>
    </section>
@endsection
