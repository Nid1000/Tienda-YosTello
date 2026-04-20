@extends('layouts.admin', ['title' => 'YO-TELLO | Editar Promocion'])

@section('content')
    <section class="section compact">
        <div class="container auth-shell">
            <div class="auth-card wide-card">
                <p class="eyebrow">Administrador</p>
                <h1>Editar promocion</h1>
                @include('admin.promotions.partials.form', [
                    'action' => route('admin.promociones.update', $promotion),
                    'method' => 'PUT',
                    'promotion' => $promotion,
                    'categories' => $categories,
                    'products' => $products,
                ])
            </div>
        </div>
    </section>
@endsection
