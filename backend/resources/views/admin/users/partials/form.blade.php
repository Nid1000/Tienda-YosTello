@csrf

<div class="checkout-grid two-columns">
    <label>
        <span>Nombres</span>
        <input type="text" name="first_name" value="{{ old('first_name', $user->first_name ?? '') }}" required>
    </label>

    <label>
        <span>Apellidos</span>
        <input type="text" name="last_name" value="{{ old('last_name', $user->last_name ?? '') }}" required>
    </label>

    <label>
        <span>Email</span>
        <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required>
    </label>

    <label>
        <span>Telefono</span>
        <input type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}">
    </label>

    <label>
        <span>Distrito</span>
        <input type="text" name="district" value="{{ old('district', $user->district ?? '') }}">
    </label>

    <label>
        <span>Numero de casa</span>
        <input type="text" name="house_number" value="{{ old('house_number', $user->house_number ?? '') }}">
    </label>

    <label>
        <span>Contrasena</span>
        <input
            type="password"
            name="password"
            @if (! isset($user)) required @endif
            placeholder="{{ isset($user) ? 'Dejar vacio para conservarla' : 'Minimo 8 caracteres' }}"
        >
    </label>
</div>

<label>
    <span>Direccion</span>
    <input type="text" name="address" value="{{ old('address', $user->address ?? '') }}">
</label>

<div class="checkout-actions-panel">
    <a class="button secondary" href="{{ route('admin.usuarios.index') }}">Cancelar</a>
    <button class="button primary" type="submit">{{ $submitLabel }}</button>
</div>
