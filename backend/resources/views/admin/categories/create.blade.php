@extends('layouts.admin', ['title' => 'YO-TELLO | Nueva Categoria'])

@section('content')
    <section class="section compact">
        <div class="container auth-shell">
            <div class="panel-card">
                <p class="eyebrow">Administrador</p>
                <h1>Nueva categoria</h1>
                @include('admin.categories.partials.form', [
                    'action' => route('admin.categorias.store'),
                    'method' => 'POST',
                    'category' => null,
                ])
            </div>
        </div>
    </section>
@endsection
