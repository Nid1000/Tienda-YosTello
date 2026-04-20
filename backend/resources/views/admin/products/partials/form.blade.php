<form method="POST" action="{{ $action }}" class="stack-form">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <label>
        <span>Nombre</span>
        <input type="text" name="name" value="{{ old('name', $product?->name) }}" required>
    </label>
    <label>
        <span>Categoria</span>
        <select name="category_id" required>
            <option value="">Selecciona una categoria</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected((string) old('category_id', $product?->category_id) === (string) $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </label>
    <label>
        <span>Descripcion</span>
        <textarea name="description" rows="4" required>{{ old('description', $product?->description) }}</textarea>
    </label>
    <label>
        <span>Precio</span>
        <input type="number" step="0.01" name="price" value="{{ old('price', $product?->price) }}" required>
    </label>
    <label>
        <span>Costo base</span>
        <input type="number" step="0.01" name="cost_price" value="{{ old('cost_price', $product?->cost_price ?? 0) }}" required>
    </label>
    <label>
        <span>Descuento %</span>
        <input type="number" step="0.01" min="0" max="90" name="discount_percent" value="{{ old('discount_percent', $product?->discount_percent ?? 0) }}" required>
    </label>
    <label>
        <span>Imagen URL</span>
        <input type="url" name="image" value="{{ old('image', $product?->image) }}" required>
    </label>
    <label>
        <span>Tallas separadas por coma</span>
        <input type="text" name="sizes" value="{{ old('sizes', $product ? implode(', ', $product->sizes) : '') }}" required>
    </label>
    <label>
        <span>Colores separados por coma</span>
        <input type="text" name="colors" value="{{ old('colors', $product ? implode(', ', $product->colors) : '') }}" required>
    </label>
    <label>
        <span>Stock</span>
        <input type="number" name="stock" min="0" value="{{ old('stock', $product?->stock ?? 0) }}" required>
    </label>
    <label class="check-row">
        <input
            type="checkbox"
            name="is_featured"
            value="1"
            @checked(old('is_featured', $product?->is_featured))
        >
        <span>Marcar como destacado</span>
    </label>
    <button class="button primary" type="submit">Guardar producto</button>
</form>
