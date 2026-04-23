@extends('layouts.admin', ['title' => 'YO-TELLO | Nuevo Usuario'])

@section('content')
    <div class="section-heading admin-heading">
        <div>
            <p class="eyebrow">Administrador</p>
            <h1>Nuevo usuario</h1>
            <p class="lead compact-lead">Crea clientes o administradores para operar la tienda.</p>
        </div>
    </div>

    <form class="panel-card stack-form wide-card" method="POST" action="{{ route('admin.usuarios.store') }}">
        @include('admin.users.partials.form', ['submitLabel' => 'Crear usuario'])
    </form>
@endsection
