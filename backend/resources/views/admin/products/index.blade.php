@extends('layouts.admin', ['title' => 'YO-TELLO | Admin Productos'])

@section('content')
    <div class="section-heading admin-heading">
        <div>
            <p class="eyebrow">Administrador</p>
            <h1>Productos</h1>
        </div>
        <a class="button primary" href="{{ route('admin.productos.create') }}">Nuevo producto</a>
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Categoria</th>
                    <th>Precio</th>
                    <th>Ganancia</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>
                            <div class="admin-product-cell">
                                <img src="{{ $product->image }}" alt="{{ $product->name }}">
                                <div>
                                    <strong>{{ $product->name }}</strong>
                                    <small class="admin-note">{{ \Illuminate\Support\Str::limit($product->description, 64) }}</small>
                                </div>
                            </div>
                        </td>
                        <td>{{ $product->category_name }}</td>
                        <td>
                            <strong>S/. {{ number_format($product->final_price, 0, ',', '.') }}</strong>
                            @if ($product->has_discount)
                                <small class="admin-note">-{{ rtrim(rtrim(number_format($product->discount_percent, 2, '.', ''), '0'), '.') }}%</small>
                            @endif
                        </td>
                        <td>S/. {{ number_format($product->profit_per_unit, 0, ',', '.') }}</td>
                        <td>{{ $product->stock }}</td>
                        <td class="actions-cell">
                            <a href="{{ route('admin.productos.edit', $product) }}">Editar</a>
                            <form method="POST" action="{{ route('admin.productos.destroy', $product) }}">
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
        {{ $products->links() }}
    </div>
@endsection
