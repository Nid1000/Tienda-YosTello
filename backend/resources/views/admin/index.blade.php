@extends('layouts.admin', ['title' => 'YO-TELLO | Administrador'])

@section('content')
    <header class="admin-topbar">
        <div>
            <p class="eyebrow">Panel de administracion</p>
            <h1>Vision general de la tienda</h1>
        </div>
    </header>

    <div class="admin-metric-grid">
        <article class="admin-metric-card">
            <span>Ventas potenciales</span>
            <strong>S/. {{ number_format($stats['projected_revenue'], 0, ',', '.') }}</strong>
        </article>
        <article class="admin-metric-card">
            <span>Productos</span>
            <strong>{{ $stats['products'] }}</strong>
        </article>
        <article class="admin-metric-card">
            <span>Categorias</span>
            <strong>{{ $stats['categories'] }}</strong>
        </article>
        <article class="admin-metric-card">
            <span>Promociones activas</span>
            <strong>{{ $stats['active_promotions'] }}</strong>
        </article>
    </div>

    <div class="admin-dashboard-grid">
                <section class="admin-surface">
                    <div class="admin-surface-head">
                        <h2>Vision general de ventas (7 dias)</h2>
                        <span>Semanal</span>
                    </div>

                    <div class="admin-chart">
                        @foreach ($weeklySales as $day)
                            <div class="admin-bar-col">
                                <div class="admin-bar-wrap">
                                    <div
                                        class="admin-bar"
                                        style="height: {{ max(8, ($day['amount'] / $maxWeeklySales) * 220) }}px"
                                        title="S/. {{ number_format($day['amount'], 2, ',', '.') }}"
                                    ></div>
                                </div>
                                <span>{{ $day['label'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </section>

                <section class="admin-surface">
                    <div class="admin-surface-head">
                        <h2>Rentabilidad</h2>
                        <span>Resumen</span>
                    </div>

                    <div class="admin-profit-grid">
                        <div class="admin-profit-card">
                            <span>Con descuento</span>
                            <strong>{{ $stats['discounted_products'] }}</strong>
                        </div>
                        <div class="admin-profit-card">
                            <span>Inventario</span>
                            <strong>S/. {{ number_format($stats['inventory_value'], 0, ',', '.') }}</strong>
                        </div>
                        <div class="admin-profit-card accent-card">
                            <span>Ganancia estimada</span>
                            <strong>S/. {{ number_format($stats['projected_profit'], 0, ',', '.') }}</strong>
                        </div>
                    </div>
                </section>

                <section class="admin-surface">
                    <div class="admin-surface-head">
                        <h2>Campanas activas</h2>
                        <span>{{ $stats['promotions'] }} total</span>
                    </div>

                    <div class="admin-profit-grid">
                        @forelse ($promotions as $promotion)
                            <div class="admin-profit-card">
                                <span>{{ $promotion->discount_label }}</span>
                                <strong>{{ $promotion->title }}</strong>
                                <p class="muted-copy">{{ $promotion->target_label }}</p>
                            </div>
                        @empty
                            <p class="muted-copy">Crea promociones para destacar campanas en la tienda.</p>
                        @endforelse
                    </div>
                </section>

                <section class="admin-surface admin-surface-wide">
                    <div class="admin-surface-head">
                        <h2>Pedidos recientes</h2>
                        <span>Ultimos movimientos</span>
                    </div>

                    <div class="admin-order-list">
                        @forelse ($orders as $order)
                            <article class="admin-order-item">
                                <div>
                                    <strong>Pedido #{{ $order->id }}</strong>
                                    <p>{{ $order->created_at?->format('d/m/Y H:i') }}</p>
                                </div>
                                <span class="admin-status">{{ ucfirst($order->status) }}</span>
                                <strong>S/. {{ number_format($order->total, 2, ',', '.') }}</strong>
                            </article>
                        @empty
                            <p class="muted-copy">No hay pedidos recientes todavia.</p>
                        @endforelse
                    </div>
                </section>
    </div>
@endsection
