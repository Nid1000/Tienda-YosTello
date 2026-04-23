<x-guest-layout title="YO-TELLO | Iniciar sesion">
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="section-heading">
        <p class="eyebrow">Cuenta YO-TELLO</p>
        <h2>Iniciar sesion</h2>
        <p class="compact-lead">Accede a tu carrito, pedidos y beneficios de la tienda.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="stack-form">
        @csrf

        <label>
            <span>Correo electronico</span>
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </label>

        <label>
            <span>Contrasena</span>
            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </label>

        <label for="remember_me" class="check-row">
            <input id="remember_me" type="checkbox" name="remember">
            <span>Recordarme</span>
        </label>

        <div class="checkout-actions-panel">
            @if (Route::has('password.request'))
                <a class="muted-copy" href="{{ route('password.request') }}">Olvide mi contrasena</a>
            @endif

            <button class="button primary" type="submit">Entrar</button>
        </div>

        <p class="compact-lead">
            ¿Primera vez en YO-TELLO?
            <a class="danger-link" href="{{ route('register') }}">Crear cuenta</a>
        </p>
    </form>
</x-guest-layout>
