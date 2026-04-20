@extends('layouts.app', ['title' => 'YO-TELLO | Inicio'])

@section('content')
    <section class="hero">
        <div class="container hero-grid">
            <div class="hero-copy">
                <div class="hero-banner">
                    <div class="hero-banner-copy">
                        <p class="eyebrow light">
                            @auth
                                Hola, {{ $userSummary['name'] }}
                            @else
                                Coleccion 2026
                            @endauth
                        </p>
                        <h1>Compra con el mismo flujo vivo de Delicias, ahora para tu tienda de ropa.</h1>
                        <p class="lead hero-lead">
                            @auth
                                Revisa tu carrito, sigue tus pedidos y salta directo al catalogo o al checkout desde una sola portada.
                            @else
                                Explora productos, descubre destacados y entra a una experiencia conectada con carrito, checkout y administracion.
                            @endauth
                        </p>
                    </div>

                    <div class="hero-highlight">
                        <span>Estado mas reciente</span>
                        <strong>
                            {{ $userSummary['latest_order_status'] ?? 'explora el catalogo' }}
                        </strong>
                    </div>
                </div>

                <div class="hero-actions">
                    <a class="button primary" href="{{ route('products.index') }}">Ir a la tienda</a>
                    @auth
                        <a class="button secondary" href="{{ $cartCount > 0 ? route('cart.index') : route('orders.index') }}">
                            {{ $cartCount > 0 ? 'Ver mi compra' : 'Ver pedidos' }}
                        </a>
                    @else
                        <a class="button secondary" href="{{ route('register') }}">Crear cuenta</a>
                    @endauth
                    <a class="button secondary" href="#destacados">Explorar destacados</a>
                </div>

                <div class="stats-grid home-stats-grid">
                    <div class="stat-card accent">
                        <strong>{{ $cartCount }}</strong>
                        <span>items en carrito</span>
                    </div>
                    <div class="stat-card">
                        <strong>{{ $userSummary['orders_count'] ?? 0 }}</strong>
                        <span>pedidos</span>
                    </div>
                    <div class="stat-card">
                        <strong>{{ $stats['discounted'] }}</strong>
                        <span>con descuento</span>
                    </div>
                    <div class="stat-card">
                        <strong>S/. {{ number_format($cartTotal, 2, '.', ',') }}</strong>
                        <span>total estimado</span>
                    </div>
                </div>
            </div>

            <div class="hero-panel hero-panel-home">
                <p class="panel-kicker">Moviendo la tienda con datos reales</p>
                @if ($latestProducts->isNotEmpty())
                    <div class="live-product">
                        <img src="{{ $latestProducts->first()->image }}" alt="{{ $latestProducts->first()->name }}">
                        <div>
                            <strong>{{ $latestProducts->first()->name }}</strong>
                            <p>{{ $latestProducts->first()->category }}</p>
                            <span>S/. {{ number_format($latestProducts->first()->final_price, 2, '.', ',') }}</span>
                        </div>
                    </div>
                @endif
                <div class="hero-panel-stats">
                    <div>
                        <strong>{{ $stats['products'] }}</strong>
                        <span>productos cargados</span>
                    </div>
                    <div>
                        <strong>{{ $stats['categories'] }}</strong>
                        <span>categorias activas</span>
                    </div>
                    <div>
                        <strong>{{ $stats['stock'] }}</strong>
                        <span>unidades en stock</span>
                    </div>
                </div>
                <ul class="hero-notes">
                    <li>Catalogo conectado a base de datos</li>
                    <li>Carrito y checkout enlazados al flujo real</li>
                    <li>Panel admin listo para gestionar productos</li>
                </ul>
            </div>
        </div>
    </section>

    <section class="section quick-section">
        <div class="container">
            <div class="section-heading">
                <p class="eyebrow">Accesos rapidos</p>
                <h2>Mueve toda la experiencia desde inicio</h2>
            </div>

            <div class="quick-grid">
                <a class="quick-card quick-card-gold" href="{{ route('products.index', ['sort' => 'latest']) }}">
                    <span>Catalogo</span>
                    <strong>Novedades y filtros</strong>
                    <p>Explora ropa, zapatillas y pantalones con el catalogo conectado al backend.</p>
                </a>
                <a class="quick-card quick-card-sand" href="{{ route('products.index', ['sort' => 'price_desc']) }}">
                    <span>Destacados</span>
                    <strong>Lo mas buscado</strong>
                    <p>Entra a productos con mejor presencia comercial y prepara tu siguiente compra.</p>
                </a>
                <a class="quick-card quick-card-blue" href="{{ auth()->check() ? route('cart.index') : route('login') }}">
                    <span>Carrito</span>
                    <strong>{{ $cartCount > 0 ? 'Continua tu compra' : 'Tu bolsa esta lista' }}</strong>
                    <p>{{ $cartCount > 0 ? 'Retoma tu carrito y sigue al checkout.' : 'Inicia sesion para empezar a guardar productos.' }}</p>
                </a>
                <a class="quick-card quick-card-dark" href="{{ auth()->check() ? route('orders.index') : route('register') }}">
                    <span>{{ auth()->check() ? 'Pedidos' : 'Cuenta' }}</span>
                    <strong>{{ auth()->check() ? 'Sigue tus compras' : 'Activa tu experiencia' }}</strong>
                    <p>{{ auth()->check() ? 'Consulta tu historial y el estado mas reciente de tus ordenes.' : 'Crea tu cuenta para guardar carrito, comprar y ver pedidos.' }}</p>
                </a>
            </div>
        </div>
    </section>

    <section class="section backend-proof-section">
        <div class="container">
            <article class="stack-panel stack-backend section-stack">
                <div class="section-heading split-heading">
                    <p class="eyebrow light-eyebrow">Backend</p>
                    <h2>Laravel, sesion y base de datos</h2>
                    <p class="lead split-lead">
                        Esta parte muestra solo la capa backend: datos reales, estado del usuario y valores que salen del servidor.
                    </p>
                </div>

                <div class="proof-list">
                    <div class="proof-item">
                        <span>Sesion actual</span>
                        <strong>{{ auth()->check() ? 'Usuario autenticado' : 'Visitante invitado' }}</strong>
                    </div>
                    <div class="proof-item">
                        <span>Ultimo producto en BD</span>
                        <strong>{{ $latestProduct?->name ?? 'Sin productos' }}</strong>
                    </div>
                    <div class="proof-item">
                        <span>Productos registrados</span>
                        <strong>{{ $stats['products'] }}</strong>
                    </div>
                    <div class="proof-item">
                        <span>Categorias activas</span>
                        <strong>{{ $stats['categories'] }}</strong>
                    </div>
                    <div class="proof-item">
                        <span>Stock total</span>
                        <strong>{{ $stats['stock'] }} unidades</strong>
                    </div>
                    <div class="proof-item">
                        <span>Pedidos del usuario</span>
                        <strong>{{ $userSummary['orders_count'] ?? 0 }}</strong>
                    </div>
                    <div class="proof-item">
                        <span>Estado mas reciente</span>
                        <strong>{{ $userSummary['latest_order_status'] ?? 'sin pedidos' }}</strong>
                    </div>
                    <div class="proof-item">
                        <span>Carrito en sesion</span>
                        <strong>{{ $cartCount }} producto(s)</strong>
                    </div>
                </div>
            </article>
        </div>
    </section>

    <section class="section frontend-proof-section">
        <div class="container">
            <article class="stack-panel stack-frontend section-stack">
                <div class="section-heading split-heading">
                    <p class="eyebrow">Frontend</p>
                    <h2>Blade, estilos y experiencia visual</h2>
                    <p class="lead compact-lead">
                        Esta parte muestra solo la capa frontend: lo que ve el usuario y como se presenta la informacion.
                    </p>
                </div>

                <div class="frontend-showcase">
                    <div class="frontend-card">
                        <span>Hero</span>
                        <strong>Presenta estado del usuario y llamadas a la accion</strong>
                        <p>El frontend convierte datos del backend en una portada clara y navegable.</p>
                    </div>
                    <div class="frontend-card">
                        <span>Catalogo</span>
                        <strong>Renderiza productos, imagenes y categorias</strong>
                        <p>Las vistas Blade muestran cards, precios, detalles y estructura visual de compra.</p>
                    </div>
                    <div class="frontend-card">
                        <span>Interaccion</span>
                        <strong>Guia al usuario hacia carrito, cuenta y checkout</strong>
                        <p>Botones, accesos rapidos y enlaces conectan la experiencia visual con el flujo de compra.</p>
                    </div>
                </div>

                @if ($featuredProduct)
                    <div class="connected-preview">
                        <img src="{{ $featuredProduct->image }}" alt="{{ $featuredProduct->name }}">
                        <div>
                            <span>Vista renderizada</span>
                            <strong>{{ $featuredProduct->name }}</strong>
                            <p>
                                Aqui ves el resultado del frontend en pantalla con un producto que llega desde el backend.
                            </p>
                        </div>
                    </div>
                @endif
            </article>
        </div>
    </section>

    @auth
        <section class="section">
            <div class="container">
                <div class="section-heading">
                    <p class="eyebrow">Tu backend personal</p>
                    <h2>Tu cuenta ya mueve datos reales</h2>
                    <p class="lead compact-lead">
                        Si querias ver el backend, aca esta reflejado en tus datos de usuario, tus pedidos y tu estado actual dentro de la tienda.
                    </p>
                </div>

                <div class="account-evidence-grid">
                    <div class="panel-card account-card">
                        <p class="eyebrow">Sesion</p>
                        <h3>{{ $userSummary['name'] }}</h3>
                        <p>{{ $userSummary['email'] }}</p>
                        <div class="proof-list compact-proof-list">
                            <div class="proof-item">
                                <span>Rol</span>
                                <strong>{{ $userSummary['role'] }}</strong>
                            </div>
                            <div class="proof-item">
                                <span>Pedidos registrados</span>
                                <strong>{{ $userSummary['orders_count'] }}</strong>
                            </div>
                            <div class="proof-item">
                                <span>Ultimo estado</span>
                                <strong>{{ $userSummary['latest_order_status'] }}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="panel-card account-card">
                        <p class="eyebrow">Pedidos</p>
                        <h3>Ultimos movimientos</h3>
                        @forelse ($recentOrders as $order)
                            <div class="home-order-row">
                                <div>
                                    <strong>Pedido #{{ $order->id }}</strong>
                                    <p>{{ $order->items->pluck('product_name')->take(2)->join(', ') ?: 'Sin items' }}</p>
                                </div>
                                <div class="home-order-meta">
                                    <span>{{ $order->status }}</span>
                                    <strong>S/. {{ number_format($order->total, 2, '.', ',') }}</strong>
                                </div>
                            </div>
                        @empty
                            <p>Aun no tienes pedidos, pero la conexion ya esta lista para guardarlos cuando completes una compra.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>
    @endauth

    <section class="section">
        <div class="container">
            <div class="section-heading">
                <p class="eyebrow">Categorias</p>
                <h2>Compra por estilo</h2>
            </div>

            <div class="category-grid">
                @foreach ($categories as $category)
                    <a class="category-card" href="{{ route('products.index', ['category' => $category->slug]) }}">
                        <div>
                            <span>{{ $category->name }}</span>
                            <small>{{ $category->products_count }} productos</small>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section" id="destacados">
        <div class="container">
            <div class="section-heading">
                <p class="eyebrow">Favoritos</p>
                <h2>Productos destacados</h2>
                <p class="lead compact-lead">
                    Una seleccion pensada para que la portada se sienta activa, igual que el flujo principal de Delicias.
                </p>
            </div>

            <div class="product-grid">
                @foreach ($featuredProducts as $product)
                    <article class="product-card">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}">
                        <div class="product-copy">
                            <p class="product-category">{{ $product->category }}</p>
                            <h3>{{ $product->name }}</h3>
                            <p>{{ \Illuminate\Support\Str::limit($product->description, 90) }}</p>
                            <div class="product-meta">
                                <div class="price-stack">
                                    <strong>S/. {{ number_format($product->final_price, 2, '.', ',') }}</strong>
                                    @if ($product->has_discount)
                                        <span class="price-old">S/. {{ number_format($product->price, 2, '.', ',') }}</span>
                                    @endif
                                </div>
                                <a href="{{ route('products.show', $product) }}">Ver detalle</a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="section-heading">
                <p class="eyebrow">Novedades</p>
                <h2>Ultimos ingresos del catalogo</h2>
                <p class="lead compact-lead">
                    Mantenemos visible lo recien publicado para que el usuario siempre tenga un siguiente paso claro.
                </p>
            </div>

            <div class="product-grid">
                @foreach ($latestProducts as $product)
                    <article class="product-card">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}">
                        <div class="product-copy">
                            <p class="product-category">{{ $product->category }}</p>
                            <h3>{{ $product->name }}</h3>
                            <p>{{ \Illuminate\Support\Str::limit($product->description, 86) }}</p>
                            <div class="product-meta">
                                <div class="price-stack">
                                    <strong>S/. {{ number_format($product->final_price, 2, '.', ',') }}</strong>
                                    @if ($product->has_discount)
                                        <span class="price-old">S/. {{ number_format($product->price, 2, '.', ',') }}</span>
                                    @endif
                                </div>
                                <a href="{{ route('products.show', $product) }}">Ver detalle</a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="experience-card">
                <div>
                    <p class="eyebrow">Experiencia conectada</p>
                    <h2>Frontend atractivo, backend utilizable</h2>
                    <p class="lead compact-lead">
                        Esta portada ya no solo presenta productos: ahora resume carrito, pedidos y accesos clave para que la tienda se sienta mas operativa y menos estatica.
                    </p>
                </div>
                <div class="experience-actions">
                    <a class="button primary" href="{{ route('products.index') }}">Explorar catalogo</a>
                    @auth
                        <a class="button secondary" href="{{ route('dashboard') }}">Ir a mi cuenta</a>
                    @else
                        <a class="button secondary" href="{{ route('login') }}">Iniciar sesion</a>
                    @endauth
                </div>
            </div>
        </div>
    </section>
@endsection
