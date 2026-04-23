@extends('layouts.admin', ['title' => 'YO-TELLO | Administrador'])

@section('content')
    <header class="admin-topbar">
        <div>
            <p class="eyebrow">Panel de administración</p>
            <h1>Visión general de la tienda</h1>
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
                        <h2>Ventas de la semana</h2>
                        <span>{{ $hasWeeklySales ? '7 días' : 'Vista preliminar' }}</span>
                    </div>

                    <div class="admin-chart {{ $hasWeeklySales ? '' : 'is-preview' }}">
                        @foreach ($weeklyChart as $day)
                            <div class="admin-bar-col">
                                <div class="admin-bar-wrap">
                                    <div
                                        class="admin-bar"
                                        style="height: {{ max(24, ($day['amount'] / $maxWeeklySales) * 220) }}px"
                                        title="S/. {{ number_format($day['amount'], 0, ',', '.') }}"
                                    ></div>
                                </div>
                                <strong>{{ $hasWeeklySales ? 'S/. '.number_format($day['amount'], 0, ',', '.') : 'Ref.' }}</strong>
                                <span>{{ $day['label'] }}</span>
                            </div>
                        @endforeach
                    </div>

                    @unless ($hasWeeklySales)
                        <p class="admin-chart-note">Aún no hay pedidos esta semana. Estas barras sirven como guía visual; se reemplazarán con ventas reales automáticamente.</p>
                    @endunless
                </section>

                <section class="admin-surface">
                    <div class="admin-surface-head">
                        <h2>Inventario por categoría</h2>
                        <span>{{ $stats['products'] }} productos</span>
                    </div>

                    <div class="admin-horizontal-chart">
                        @foreach ($categoryInventory as $category)
                            <article class="admin-hbar-row">
                                <div class="admin-hbar-label">
                                    <strong>{{ $category['name'] }}</strong>
                                    <span>{{ $category['products'] }} prod. | {{ $category['stock'] }} und.</span>
                                </div>
                                <div class="admin-hbar-track">
                                    <div class="admin-hbar" style="width: {{ max(8, ($category['stock'] / $maxCategoryStock) * 100) }}%"></div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>

                <section class="admin-surface">
                    <div class="admin-surface-head">
                        <h2>Rentabilidad</h2>
                        <span>Resumen</span>
                    </div>

                    <div class="admin-donut-wrap">
                        @php
                            $discountPercent = $stats['products'] > 0 ? round(($stats['discounted_products'] / $stats['products']) * 100) : 0;
                        @endphp
                        <div class="admin-donut" style="--value: {{ $discountPercent }}">
                            <strong>{{ $discountPercent }}%</strong>
                            <span>con descuento</span>
                        </div>
                        <div class="admin-profit-grid">
                            <div class="admin-profit-card">
                                <span>Valor de inventario</span>
                                <strong>S/. {{ number_format($stats['inventory_value'], 0, ',', '.') }}</strong>
                            </div>
                            <div class="admin-profit-card accent-card">
                                <span>Ganancia estimada</span>
                                <strong>S/. {{ number_format($stats['projected_profit'], 0, ',', '.') }}</strong>
                            </div>
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
