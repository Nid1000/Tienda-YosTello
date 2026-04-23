@extends('layouts.app', ['title' => 'YO-TELLO | Catalogo'])

@section('content')
    <section class="section compact">
        <div class="container">
            <div class="section-heading">
                <p class="eyebrow">Catalogo</p>
                <h1>Encuentra tu siguiente look</h1>
                <p class="lead compact-lead">
                    {{ $resultsCount }} resultado(s)
                    @if ($selectedCategory !== '')
                        en {{ $selectedCategory }}
                    @endif
                    @if ($search !== '')
                        para "{{ $search }}"
                    @endif
                </p>
            </div>

            <form
                class="filters"
                method="GET"
                action="{{ route('products.index') }}"
                data-auto-submit-filters
            >
                <label class="filter-field">
                    <span>Buscar producto</span>
                    <input
                        type="text"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Ropa, zapatillas o pantalones"
                    >
                </label>

                <label class="filter-field">
                    <span>Categoria</span>
                    <span class="select-field">
                        <select name="category">
                            <option value="">Todas las categorias</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->slug }}" @selected($selectedCategory === $category->slug || $selectedCategory === $category->name)>
                                    {{ $category->name }} ({{ $category->products_count }})
                                </option>
                            @endforeach
                        </select>
                    </span>
                </label>

                <label class="filter-field">
                    <span>Ordenar por</span>
                    <span class="select-field">
                        <select name="sort">
                            <option value="latest" @selected($sort === 'latest')>Mas recientes</option>
                            <option value="price_asc" @selected($sort === 'price_asc')>Precio: menor a mayor</option>
                            <option value="price_desc" @selected($sort === 'price_desc')>Precio: mayor a menor</option>
                            <option value="name_asc" @selected($sort === 'name_asc')>Nombre A-Z</option>
                        </select>
                    </span>
                </label>

                <button class="button primary" type="submit">Filtrar</button>
            </form>

            <div class="filter-chips">
                <a class="filter-chip {{ $selectedCategory === '' ? 'active' : '' }}" href="{{ route('products.index', ['search' => $search, 'sort' => $sort]) }}">
                    Todo
                </a>
                @foreach ($categories as $category)
                    <a
                        class="filter-chip {{ $selectedCategory === $category->slug || $selectedCategory === $category->name ? 'active' : '' }}"
                        href="{{ route('products.index', ['category' => $category->slug, 'search' => $search, 'sort' => $sort]) }}"
                    >
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>

            <div class="product-grid">
                @forelse ($products as $product)
                    <article class="product-card">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}">
                        <div class="product-copy">
                            <p class="product-category">{{ $product->category }}</p>
                            <h3>{{ $product->name }}</h3>
                            <p>{{ \Illuminate\Support\Str::limit($product->description, 100) }}</p>
                            <div class="product-meta">
                                <div class="price-stack">
                                    <strong>S/. {{ number_format($product->final_price, 0, '.', ',') }}</strong>
                                    @if ($product->has_discount)
                                        <span class="price-old">S/. {{ number_format($product->price, 0, '.', ',') }}</span>
                                        <span class="discount-badge">-{{ rtrim(rtrim(number_format($product->discount_percent, 2, '.', ''), '0'), '.') }}%</span>
                                    @endif
                                </div>
                                <a class="product-detail-link" href="{{ route('products.show', $product) }}">Ver detalle</a>
                            </div>
                        </div>
                    </article>
                @empty
                    <p>No hay productos para los filtros actuales.</p>
                @endforelse
            </div>

            <div class="pagination-wrap">
                {{ $products->links() }}
            </div>
        </div>
    </section>
@endsection
