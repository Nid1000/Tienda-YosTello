<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminAuthenticatedSessionController extends Controller
{
    public function create(Request $request): View|RedirectResponse
    {
        $request->session()->forget('url.intended');

        if ($request->user()?->isAdmin()) {
            return redirect()->route('admin.index');
        }

        if ($request->user()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('admin.login')
                ->with('status', 'Se cerro la sesion de cliente para abrir el acceso administrador.');
        }

        return view('auth.admin-login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'Las credenciales de administrador no son validas.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();
        $request->session()->forget('url.intended');

        if (! $request->user()->isAdmin()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->withErrors(['email' => 'Esta cuenta no tiene acceso al panel administrador.'])
                ->onlyInput('email');
        }

        return redirect()->route('admin.index')->with('status', 'Bienvenido al panel administrador.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('status', 'Sesion de administrador cerrada.');
    }
}
