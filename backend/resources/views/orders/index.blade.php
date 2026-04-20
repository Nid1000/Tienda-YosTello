@extends('layouts.app', ['title' => 'YO-TELLO | Pedidos'])

@section('content')
    <section class="section compact">
        <div class="container">
            <div class="section-heading">
                <p class="eyebrow">Pedidos</p>
                <h1>Historial de compras</h1>
            </div>

            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Estado</th>
                            <th>Metodo</th>
                            <th>Total</th>
                            <th>Productos</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->status }}</td>
                                <td>{{ $order->payment_method }}</td>
                                <td>S/. {{ number_format($order->total, 2, '.', ',') }}</td>
                                <td>{{ $order->items->pluck('product_name')->join(', ') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">No hay pedidos registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
