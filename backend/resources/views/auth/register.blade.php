<x-guest-layout title="YO-TELLO | Crear cuenta">
    <div class="section-heading">
        <p class="eyebrow">Nueva cuenta</p>
        <h2>Unete a YO-TELLO</h2>
        <p class="compact-lead">Crea tu perfil para comprar ropa, zapatillas y seguir tus pedidos.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="stack-form">
        @csrf

        <label>
            <span>Nombre completo</span>
            <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </label>

        <label>
            <span>Correo electronico</span>
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </label>

        <label>
            <span>Contrasena</span>
            <x-text-input id="password" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </label>

        <label>
            <span>Confirmar contrasena</span>
            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </label>

        <div class="checkout-actions-panel">
            <a class="muted-copy" href="{{ route('login') }}">Ya tengo cuenta</a>
            <button class="button primary" type="submit">Crear cuenta</button>
        </div>
    </form>
</x-guest-layout>
