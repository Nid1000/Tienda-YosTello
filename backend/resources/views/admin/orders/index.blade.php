@extends('layouts.admin', ['title' => 'YO-TELLO | Admin Pedidos'])

@section('content')
    <div class="section-heading admin-heading">
        <div>
            <p class="eyebrow">Administrador</p>
            <h1>Pedidos</h1>
            <p class="lead compact-lead">Revisa las compras registradas y el detalle de productos de cada pedido.</p>
        </div>
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Estado</th>
                    <th>Metodo</th>
                    <th>Total</th>
                    <th>Productos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>
                            <strong>{{ $order->customer_name }}</strong>
                            <small class="admin-note">{{ $order->user?->email ?? 'Sin usuario' }}</small>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.pedidos.update', $order) }}" class="admin-inline-form">
                                @csrf
                                @method('PATCH')
                                <select name="status" aria-label="Estado del pedido #{{ $order->id }}">
                                    @foreach ($statuses as $value => $label)
                                        <option value="{{ $value }}" @selected($order->status === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                                <button class="button secondary" type="submit">Guardar</button>
                            </form>
                        </td>
                        <td>{{ $order->payment_method }}</td>
                        <td>S/. {{ number_format($order->total, 2, '.', ',') }}</td>
                        <td>{{ $order->items->pluck('product_name')->join(', ') }}</td>
                        <td>
                            <small class="admin-note">
                                {{ $order->created_at?->format('d/m/Y H:i') }}
                            </small>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">No hay pedidos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrap">
        {{ $orders->links() }}
    </div>
@endsection
