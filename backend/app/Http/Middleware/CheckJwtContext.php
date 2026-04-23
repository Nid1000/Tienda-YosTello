<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use App\Models\User;
use App\Services\JwtService;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class CheckJwtContext
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $token = $request->bearerToken();

        if (! $token) {
            return $this->unauthorized('Token requerido.');
        }

        try {
            $claims = app(JwtService::class)->decode($token);
        } catch (Throwable $exception) {
            return $this->unauthorized($exception->getMessage());
        }

        if (($claims['role'] ?? null) !== $role) {
            return $this->forbidden('El token no pertenece a este contexto.');
        }

        $actor = $role === 'admin'
            ? Admin::query()->whereKey($claims['id'] ?? null)->where('is_active', true)->first()
            : User::query()->whereKey($claims['id'] ?? null)->where('role', 'customer')->first();

        if (! $actor) {
            return $this->unauthorized('Sesion JWT no valida.');
        }

        $request->attributes->set('auth_actor', $actor);
        $request->attributes->set('auth_claims', $claims);

        return $next($request);
    }

    protected function unauthorized(string $message): JsonResponse
    {
        return response()->json([
            'message' => $message,
        ], 401);
    }

    protected function forbidden(string $message): JsonResponse
    {
        return response()->json([
            'message' => $message,
        ], 403);
    }
}
