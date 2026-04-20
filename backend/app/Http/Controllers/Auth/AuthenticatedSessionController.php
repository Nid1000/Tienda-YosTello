<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(Request $request): View|RedirectResponse
    {
        if (str_starts_with((string) $request->session()->get('url.intended'), url('/admin'))) {
            $request->session()->forget('url.intended');
        }

        if ($request->user()?->isAdmin()) {
            return redirect()->route('admin.index');
        }

        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'Las credenciales no son validas.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        if ($request->user()->isAdmin()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->withErrors(['email' => 'Esta cuenta es de administrador. Usa el acceso privado del panel admin.'])
                ->onlyInput('email');
        }

        if (str_starts_with((string) $request->session()->get('url.intended'), url('/admin'))) {
            $request->session()->forget('url.intended');
        }

        return redirect()->intended(route('dashboard'))->with('status', 'Bienvenido de nuevo.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('status', 'Sesion cerrada correctamente.');
    }
}
