@extends('layouts.admin', ['title' => 'YO-TELLO | Admin Usuarios'])

@section('content')
    <div class="section-heading admin-heading">
        <div>
            <p class="eyebrow">Administrador</p>
            <h1>Usuarios</h1>
            <p class="lead compact-lead">Consulta clientes y administradores registrados en la tienda.</p>
        </div>
        <a class="button primary" href="{{ route('admin.usuarios.create') }}">Nuevo usuario</a>
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
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>
                            <strong>{{ $user->name }}</strong>
                            @if ($user->phone)
                                <small class="admin-note">{{ $user->phone }}</small>
                            @endif
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $roles[$user->role] ?? $user->role }}</td>
                        <td>{{ $user->orders_count }}</td>
                        <td>{{ $user->created_at?->format('d/m/Y') }}</td>
                        <td class="actions-cell">
                            <a href="{{ route('admin.usuarios.edit', $user) }}">Editar</a>
                            @if (auth()->id() !== $user->id)
                                <form method="POST" action="{{ route('admin.usuarios.destroy', $user) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="nav-button danger-link" type="submit">Eliminar</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No hay usuarios registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrap">
        {{ $users->links() }}
    </div>
@endsection
