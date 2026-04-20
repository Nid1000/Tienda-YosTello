@extends('layouts.app', ['title' => 'YO-TELLO | Registro'])

@section('content')
    <section class="section compact">
        <div class="container auth-shell">
            <div class="auth-card wide-card">
                <p class="eyebrow">Nueva cuenta</p>
                <h1>Registrate</h1>
                <form method="POST" action="{{ route('register') }}" class="stack-form">
                    @csrf
                    <div class="checkout-grid two-columns">
                        <label>
                            <span>Nombre</span>
                            <input type="text" name="first_name" value="{{ old('first_name') }}" required>
                            @error('first_name') <small>{{ $message }}</small> @enderror
                        </label>
                        <label>
                            <span>Apellido</span>
                            <input type="text" name="last_name" value="{{ old('last_name') }}" required>
                            @error('last_name') <small>{{ $message }}</small> @enderror
                        </label>
                    </div>

                    <label>
                        <span>Email</span>
                        <input type="email" name="email" value="{{ old('email') }}" required>
                        @error('email') <small>{{ $message }}</small> @enderror
                    </label>

                    <label>
                        <span>Contrasena</span>
                        <input type="password" name="password" required>
                        <small>Minimo 8 caracteres.</small>
                        @error('password') <small>{{ $message }}</small> @enderror
                    </label>

                    <div class="checkout-grid two-columns">
                        <label>
                            <span>Telefono</span>
                            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="987654321" required>
                            @error('phone') <small>{{ $message }}</small> @enderror
                        </label>
                        <label>
                            <span>Numero de casa</span>
                            <input type="text" name="house_number" value="{{ old('house_number') }}" placeholder="Ej: 350" required>
                            @error('house_number') <small>{{ $message }}</small> @enderror
                        </label>
                    </div>

                    <label>
                        <span>Direccion</span>
                        <input type="text" name="address" value="{{ old('address') }}" placeholder="Av. / Jr. / Calle" required>
                        @error('address') <small>{{ $message }}</small> @enderror
                    </label>

                    <label>
                        <span>Distrito</span>
                        <select name="district" required>
                            <option value="">Selecciona tu distrito</option>
                            @foreach (['Miraflores', 'San Isidro', 'Surco', 'La Molina', 'San Borja', 'Lince', 'Jesus Maria', 'Los Olivos', 'Comas', 'San Juan de Lurigancho', 'Ate', 'Chorrillos', 'Callao'] as $district)
                                <option value="{{ $district }}" @selected(old('district') === $district)>{{ $district }}</option>
                            @endforeach
                        </select>
                        @error('district') <small>{{ $message }}</small> @enderror
                    </label>

                    <button class="button primary" type="submit">Crear cuenta</button>
                </form>
                <p class="auth-footer">
                    Ya tienes cuenta?
                    <a href="{{ route('login') }}">Iniciar sesion</a>
                </p>
            </div>
        </div>
    </section>
@endsection
