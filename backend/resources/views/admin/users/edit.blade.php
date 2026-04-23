@extends('layouts.admin', ['title' => 'YO-TELLO | Editar Usuario'])

@section('content')
    <div class="section-heading admin-heading">
        <div>
            <p class="eyebrow">Administrador</p>
            <h1>Editar usuario</h1>
            <p class="lead compact-lead">Actualiza datos de contacto, rol y acceso.</p>
        </div>
    </div>

    <form class="panel-card stack-form wide-card" method="POST" action="{{ route('admin.usuarios.update', $user) }}">
        @method('PUT')
        @include('admin.users.partials.form', ['submitLabel' => 'Guardar cambios'])
    </form>
@endsection
