@extends('layouts.app', ['title' => 'YO-TELLO | Carrito'])

@section('content')
    <section class="section compact">
        <div class="container cart-checkout-shell">
            <div class="cart-main">
                <div class="checkout-steps">
                    <span class="active">Resumen de la compra</span>
                    <span>Datos del cliente</span>
                    <span>Pago y envio</span>
                </div>

                <div class="panel-card cart-panel">
                    <div class="cart-header-row">
                        <div>
                            <p class="eyebrow">Carrito de compra</p>
                            <h1>Tu bolsa de compra</h1>
                        </div>
                        <a class="button secondary" href="{{ route('products.index') }}">Agregar mas productos</a>
                    </div>

                    <div class="cart-table-head">
                        <span>Productos ({{ $itemsCount }})</span>
                        <span>Cantidad</span>
                        <span>Total</span>
                    </div>

                    @forelse ($products as $product)
                        <div class="cart-item gzuck-cart-item">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}">
                            <div class="cart-copy">
                                <p class="product-category">{{ $product->category }}</p>
                                <h3>{{ $product->name }}</h3>
                                <p>Talla: {{ $product->cart_size }}</p>
                                <p>Precio final: S/. {{ number_format($product->final_price, 2, '.', ',') }}</p>
                                @if ($product->has_discount)
                                    <p class="muted-copy">Antes: S/. {{ number_format($product->price, 2, '.', ',') }} | Descuento: {{ rtrim(rtrim(number_format($product->discount_percent, 2, '.', ''), '0'), '.') }}%</p>
                                @endif
                                <form method="POST" action="{{ route('cart.destroy', $product) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="nav-button danger-link" type="submit">Eliminar</button>
                                </form>
                            </div>
                            <form method="POST" action="{{ route('cart.update', $product) }}" class="cart-qty-form">
                                @csrf
                                @method('PATCH')
                                <div class="qty-box">
                                    <button type="button" class="qty-button" data-qty-action="decrease">-</button>
                                    <input type="number" name="quantity" min="1" max="10" value="{{ $product->cart_quantity }}">
                                    <button type="button" class="qty-button" data-qty-action="increase">+</button>
                                </div>
                                <button class="button secondary" type="submit">Actualizar</button>
                            </form>
                            <div class="cart-subtotal">
                                <strong>S/. {{ number_format($product->cart_subtotal, 2, '.', ',') }}</strong>
                            </div>
                        </div>
                    @empty
                        <div class="empty-cart">
                            <h3>Tu carrito de compras esta vacio</h3>
                            <p>Para seguir comprando, navega por nuestras categorias y descubre todo lo que tenemos para ti.</p>
                            <a class="button primary" href="{{ route('products.index') }}">Ver catalogo</a>
                        </div>
                    @endforelse
                </div>
            </div>

            <aside class="panel-card checkout-summary-card">
                <p class="eyebrow">Resumen de la compra</p>
                <div class="summary-row">
                    <span>Subtotal</span>
                    <strong>S/. {{ number_format($subtotal, 2, '.', ',') }}</strong>
                </div>
                <div class="summary-row">
                    <span>Envio estimado</span>
                    <strong>S/. {{ number_format($shippingCost, 2, '.', ',') }}</strong>
                </div>
                <div class="summary-divider"></div>
                <div class="summary-row total">
                    <span>Total estimado</span>
                    <strong>S/. {{ number_format($total, 2, '.', ',') }}</strong>
                </div>
                <p class="summary-note">Todas las transacciones son seguras.</p>
                <a class="button primary full-width" href="{{ route('checkout.create') }}">Ir a comprar</a>
            </aside>
        </div>
    </section>
@endsection
