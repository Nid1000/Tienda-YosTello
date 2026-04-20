<form method="POST" action="{{ $action }}" class="stack-form">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <label>
        <span>Titulo de la promocion</span>
        <input type="text" name="title" value="{{ old('title', $promotion?->title) }}" required>
    </label>
    <label>
        <span>Descripcion</span>
        <textarea name="description" rows="4">{{ old('description', $promotion?->description) }}</textarea>
    </label>
    <div class="checkout-grid two-columns">
        <label>
            <span>Codigo promocional</span>
            <input type="text" name="code" value="{{ old('code', $promotion?->code) }}" placeholder="ATELIER15">
        </label>
        <label>
            <span>Etiqueta visible</span>
            <input type="text" name="badge_text" value="{{ old('badge_text', $promotion?->badge_text) }}" placeholder="Edicion limitada">
        </label>
        <label>
            <span>Tipo de descuento</span>
            <select name="discount_type" required>
                <option value="percentage" @selected(old('discount_type', $promotion?->discount_type ?? 'percentage') === 'percentage')>Porcentaje</option>
                <option value="fixed" @selected(old('discount_type', $promotion?->discount_type) === 'fixed')>Monto fijo</option>
            </select>
        </label>
        <label>
            <span>Valor</span>
            <input type="number" step="0.01" min="0" name="discount_value" value="{{ old('discount_value', $promotion?->discount_value ?? 0) }}" required>
        </label>
        <label>
            <span>Aplica a</span>
            <select name="target_type" required>
                <option value="all" @selected(old('target_type', $promotion?->target_type ?? 'all') === 'all')>Toda la tienda</option>
                <option value="category" @selected(old('target_type', $promotion?->target_type) === 'category')>Categoria</option>
                <option value="product" @selected(old('target_type', $promotion?->target_type) === 'product')>Producto</option>
            </select>
        </label>
        <label>
            <span>Imagen editorial URL</span>
            <input type="url" name="hero_image" value="{{ old('hero_image', $promotion?->hero_image) }}">
        </label>
        <label>
            <span>Categoria objetivo</span>
            <select name="category_id">
                <option value="">Sin categoria especifica</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected((string) old('category_id', $promotion?->category_id) === (string) $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </label>
        <label>
            <span>Producto objetivo</span>
            <select name="product_id">
                <option value="">Sin producto especifico</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}" @selected((string) old('product_id', $promotion?->product_id) === (string) $product->id)>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
        </label>
        <label>
            <span>Inicio</span>
            <input type="datetime-local" name="starts_at" value="{{ old('starts_at', $promotion?->starts_at?->format('Y-m-d\TH:i')) }}">
        </label>
        <label>
            <span>Fin</span>
            <input type="datetime-local" name="ends_at" value="{{ old('ends_at', $promotion?->ends_at?->format('Y-m-d\TH:i')) }}">
        </label>
    </div>
    <label class="check-row">
        <input
            type="checkbox"
            name="is_active"
            value="1"
            @checked(old('is_active', $promotion?->is_active ?? true))
        >
        <span>Promocion activa</span>
    </label>
    <button class="button primary" type="submit">Guardar promocion</button>
</form>
