<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAuthAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        abort_unless(
            $request->session()->get('auth_context') === 'admin'
            && $request->session()->get('auth_role') === 'admin',
            403
        );

        return $next($request);
    }
}
