<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UseContextSessionCookie
{
    public function handle(Request $request, Closure $next): Response
    {
        config([
            'session.cookie' => $request->is('admin') || $request->is('admin/*')
                ? 'session_id_admin'
                : 'session_id_client',
        ]);

        return $next($request);
    }
}
