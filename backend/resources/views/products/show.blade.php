@extends('layouts.app', ['title' => 'YO-TELLO | '.$product->name])

@section('content')
    <section class="section compact">
        <div class="container product-detail">
            <div>
                <img class="detail-image" src="{{ $product->image }}" alt="{{ $product->name }}">
            </div>

            <div class="detail-copy">
                <p class="product-category">{{ $product->category }}</p>
                <h1>{{ $product->name }}</h1>
                <div class="detail-price-wrap">
                    <p class="detail-price">S/. {{ number_format($product->final_price, 2, '.', ',') }}</p>
                    @if ($product->has_discount)
                        <p class="detail-price-old">Antes S/. {{ number_format($product->price, 2, '.', ',') }}</p>
                        <p class="discount-inline">Descuento de {{ rtrim(rtrim(number_format($product->discount_percent, 2, '.', ''), '0'), '.') }}%</p>
                    @endif
                </div>
                <p>{{ $product->description }}</p>

                <div class="detail-box">
                    <p><strong>Tallas:</strong> {{ implode(', ', $product->sizes) }}</p>
                    <p><strong>Colores:</strong> {{ implode(', ', $product->colors) }}</p>
                    <p><strong>Stock disponible:</strong> {{ $product->stock }}</p>
                </div>

                @auth
                    <form class="stack-form detail-form" method="POST" action="{{ route('cart.store') }}">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <label>
                            <span>Talla</span>
                            <select name="size" required>
                                @foreach ($product->sizes as $size)
                                    <option value="{{ $size }}">{{ $size }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label>
                            <span>Cantidad</span>
                            <input type="number" name="quantity" min="1" max="10" value="1" required>
                        </label>
                        <button class="button primary" type="submit">Agregar al carrito</button>
                    </form>
                @else
                    <a class="button primary" href="{{ route('login') }}">Inicia sesion para comprar</a>
                @endauth
            </div>
        </div>
    </section>

    <section class="section related">
        <div class="container">
            <div class="section-heading">
                <p class="eyebrow">Relacionados</p>
                <h2>Mas opciones para combinar</h2>
            </div>

            <div class="product-grid">
                @foreach ($relatedProducts as $related)
                    <article class="product-card">
                        <img src="{{ $related->image }}" alt="{{ $related->name }}">
                        <div class="product-copy">
                            <p class="product-category">{{ $related->category }}</p>
                            <h3>{{ $related->name }}</h3>
                            <div class="product-meta">
                                <div class="price-stack">
                                    <strong>S/. {{ number_format($related->final_price, 2, '.', ',') }}</strong>
                                    @if ($related->has_discount)
                                        <span class="price-old">S/. {{ number_format($related->price, 2, '.', ',') }}</span>
                                    @endif
                                </div>
                                <a href="{{ route('products.show', $related) }}">Ver detalle</a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
