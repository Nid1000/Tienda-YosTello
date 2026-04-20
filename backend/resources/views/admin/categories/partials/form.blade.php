<form method="POST" action="{{ $action }}" class="stack-form">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <label>
        <span>Nombre</span>
        <input type="text" name="name" value="{{ old('name', $category?->name) }}" required>
    </label>
    <label>
        <span>Descripcion</span>
        <textarea name="description" rows="4">{{ old('description', $category?->description) }}</textarea>
    </label>
    <label>
        <span>Imagen URL</span>
        <input type="url" name="image" value="{{ old('image', $category?->image) }}">
    </label>
    <label>
        <span>Orden</span>
        <input type="number" name="sort_order" min="0" value="{{ old('sort_order', $category?->sort_order ?? 0) }}" required>
    </label>
    <label class="check-row">
        <input
            type="checkbox"
            name="is_active"
            value="1"
            @checked(old('is_active', $category?->is_active ?? true))
        >
        <span>Categoria activa</span>
    </label>
    <button class="button primary" type="submit">Guardar categoria</button>
</form>
