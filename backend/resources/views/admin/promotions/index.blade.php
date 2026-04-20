@extends('layouts.admin', ['title' => 'YO-TELLO | Admin Promociones'])

@section('content')
    <div class="section-heading admin-heading">
        <div>
            <p class="eyebrow">Administrador</p>
            <h1>Promociones</h1>
            <p class="lead compact-lead">Crea campanas, codigos y mensajes visibles para la tienda.</p>
        </div>
        <a class="button primary" href="{{ route('admin.promociones.create') }}">Nueva promocion</a>
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Promocion</th>
                    <th>Codigo</th>
                    <th>Descuento</th>
                    <th>Aplica a</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($promotions as $promotion)
                    <tr>
                        <td>
                            <strong>{{ $promotion->title }}</strong>
                            <small class="admin-note">{{ $promotion->badge_text ?? 'Sin etiqueta' }}</small>
                        </td>
                        <td>{{ $promotion->code ?? 'Sin codigo' }}</td>
                        <td>{{ $promotion->discount_label }}</td>
                        <td>{{ $promotion->target_label }}</td>
                        <td>{{ $promotion->is_active ? 'Activa' : 'Inactiva' }}</td>
                        <td class="actions-cell">
                            <a href="{{ route('admin.promociones.edit', $promotion) }}">Editar</a>
                            <form method="POST" action="{{ route('admin.promociones.destroy', $promotion) }}">
                                @csrf
                                @method('DELETE')
                                <button class="nav-button danger-link" type="submit">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Todavia no hay promociones creadas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrap">
        {{ $promotions->links() }}
    </div>
@endsection
