<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:120'],
            'last_name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'phone' => ['required', 'string', 'max:30'],
            'house_number' => ['required', 'string', 'max:40'],
            'address' => ['required', 'string', 'max:255'],
            'district' => ['required', 'string', 'max:120'],
        ], [
            'first_name.required' => 'Ingresa tu nombre.',
            'last_name.required' => 'Ingresa tu apellido.',
            'email.required' => 'Ingresa tu correo.',
            'email.email' => 'Ingresa un correo valido.',
            'email.unique' => 'Ese correo ya esta registrado.',
            'password.required' => 'Ingresa una contrasena.',
            'password.min' => 'La contrasena debe tener minimo 8 caracteres.',
            'phone.required' => 'Ingresa tu telefono.',
            'house_number.required' => 'Ingresa tu numero de casa.',
            'address.required' => 'Ingresa tu direccion.',
            'district.required' => 'Selecciona tu distrito.',
        ]);

        $user = User::query()->create([
            'name' => trim($data['first_name'].' '.$data['last_name']),
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'house_number' => $data['house_number'],
            'address' => $data['address'],
            'district' => $data['district'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('status', 'Tu cuenta fue creada correctamente.');
    }
}
