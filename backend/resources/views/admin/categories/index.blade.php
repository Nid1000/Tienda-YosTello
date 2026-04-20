@extends('layouts.admin', ['title' => 'YO-TELLO | Admin Categorias'])

@section('content')
    <div class="section-heading admin-heading">
        <div>
            <p class="eyebrow">Administrador</p>
            <h1>Categorias</h1>
        </div>
        <a class="button primary" href="{{ route('admin.categorias.create') }}">Nueva categoria</a>
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Categoria</th>
                    <th>Slug</th>
                    <th>Productos</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->slug }}</td>
                        <td>{{ $category->products_count }}</td>
                        <td>{{ $category->is_active ? 'Activa' : 'Inactiva' }}</td>
                        <td class="actions-cell">
                            <a href="{{ route('admin.categorias.edit', $category) }}">Editar</a>
                            <form method="POST" action="{{ route('admin.categorias.destroy', $category) }}">
                                @csrf
                                @method('DELETE')
                                <button class="nav-button danger-link" type="submit">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="pagination-wrap">
        {{ $categories->links() }}
    </div>
@endsection
