<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\View\View;

class AdminAuthenticatedSessionController extends Controller
{
    public function create(Request $request): View|RedirectResponse
    {
        $request->session()->forget('url.intended');

        if (Auth::guard('admin')->check() && $request->session()->get('auth_context') === 'admin') {
            return redirect()->route('admin.index');
        }

        return view('auth.admin-login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'Las credenciales de administrador no son validas.'])
                ->onlyInput('email');
        }

        if (! Auth::guard('admin')->user()->is_active) {
            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->withErrors(['email' => 'Esta cuenta administradora esta desactivada.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();
        $request->session()->forget('url.intended');
        $request->session()->put('auth_context', 'admin');
        $request->session()->put('auth_role', 'admin');

        return redirect()
            ->route('admin.index')
            ->with('status', 'Bienvenido al panel administrador.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('admin.login')
            ->with('status', 'Sesion de administrador cerrada.')
            ->withCookie(Cookie::forget('session_id_admin'));
    }
}
