@extends('layouts.admin', ['title' => 'YO-TELLO | Editar Categoria'])

@section('content')
    <section class="section compact">
        <div class="container auth-shell">
            <div class="panel-card">
                <p class="eyebrow">Administrador</p>
                <h1>Editar categoria</h1>
                @include('admin.categories.partials.form', [
                    'action' => route('admin.categorias.update', $category),
                    'method' => 'PUT',
                    'category' => $category,
                ])
            </div>
        </div>
    </section>
@endsection
