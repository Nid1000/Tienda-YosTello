@extends('layouts.admin', ['title' => 'YO-TELLO | Admin Usuarios'])

@section('content')
    <div class="section-heading admin-heading">
        <div>
            <p class="eyebrow">Administrador</p>
            <h1>Usuarios</h1>
            <p class="lead compact-lead">Consulta clientes y administradores registrados en la tienda.</p>
        </div>
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Pedidos</th>
                    <th>Registro</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->isAdmin() ? 'Administrador' : 'Cliente' }}</td>
                        <td>{{ $user->orders_count }}</td>
                        <td>{{ $user->created_at?->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No hay usuarios registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrap">
        {{ $users->links() }}
    </div>
@endsection
