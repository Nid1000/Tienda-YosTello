<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()?->isAdmin()) {
            return redirect()
                ->route('admin.index')
                ->with('status', 'El administrador solo puede ingresar al panel de administracion.');
        }

        return $next($request);
    }
}
