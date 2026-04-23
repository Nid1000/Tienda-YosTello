<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAuthClient
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('admin')->check() || $request->session()->get('auth_context') === 'admin') {
            return redirect()
                ->route('admin.index')
                ->with('status', 'El administrador solo puede ingresar al panel de administracion.');
        }

        if (Auth::guard('web')->check()) {
            abort_unless(
                $request->session()->get('auth_context') === 'store'
                && $request->session()->get('auth_role') === 'customer',
                403
            );
        }

        return $next($request);
    }
}
