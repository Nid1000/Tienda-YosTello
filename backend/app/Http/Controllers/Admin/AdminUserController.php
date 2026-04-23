<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public const ROLES = [
        'customer' => 'Cliente',
    ];

    public function index(): View
    {
        return view('admin.users.index', [
            'users' => User::query()
                ->withCount('orders')
                ->latest()
                ->paginate(12),
            'roles' => self::ROLES,
        ]);
    }

    public function create(): View
    {
        return view('admin.users.create', [
            'roles' => self::ROLES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['password'] = Hash::make($data['password']);
        $data['name'] = trim($data['first_name'].' '.$data['last_name']);
        $data['role'] = 'customer';

        User::query()->create($data);

        return redirect()->route('admin.usuarios.index')->with('status', 'Usuario creado correctamente.');
    }

    public function edit(User $usuario): View
    {
        return view('admin.users.edit', [
            'user' => $usuario,
            'roles' => self::ROLES,
        ]);
    }

    public function update(Request $request, User $usuario): RedirectResponse
    {
        $data = $this->validatedData($request, $usuario);

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $data['name'] = trim($data['first_name'].' '.$data['last_name']);
        $data['role'] = 'customer';
        $usuario->update($data);

        return redirect()->route('admin.usuarios.index')->with('status', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $usuario): RedirectResponse
    {
        if (auth()->id() === $usuario->id) {
            return back()->withErrors(['user' => 'No puedes eliminar tu propio usuario.']);
        }

        $usuario->delete();

        return redirect()->route('admin.usuarios.index')->with('status', 'Usuario eliminado correctamente.');
    }

    protected function validatedData(Request $request, ?User $user = null): array
    {
        return $request->validate([
            'first_name' => ['required', 'string', 'max:120'],
            'last_name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user)],
            'phone' => ['nullable', 'string', 'max:30'],
            'house_number' => ['nullable', 'string', 'max:40'],
            'address' => ['nullable', 'string', 'max:255'],
            'district' => ['nullable', 'string', 'max:120'],
            'password' => [$user ? 'nullable' : 'required', 'string', 'min:8'],
        ]);
    }
}
