<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Services\JwtService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function login(Request $request, JwtService $jwt): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $admin = Admin::query()
            ->where('email', $credentials['email'])
            ->where('is_active', true)
            ->first();

        if (! $admin || ! Hash::check($credentials['password'], $admin->password)) {
            return response()->json([
                'message' => 'Credenciales de administrador no válidas.',
            ], 422);
        }

        return response()->json([
            'token_type' => 'Bearer',
            'access_token' => $jwt->encode([
                'id' => $admin->id,
                'role' => 'admin',
                'context' => 'admin',
                'email' => $admin->email,
            ]),
            'admin' => [
                'id' => $admin->id,
                'name' => $admin->name,
                'email' => $admin->email,
                'role' => 'admin',
            ],
        ]);
    }

    public function me(Request $request): JsonResponse
    {
        $admin = $request->attributes->get('auth_actor');

        return response()->json([
            'admin' => [
                'id' => $admin->id,
                'name' => $admin->name,
                'email' => $admin->email,
                'role' => 'admin',
            ],
            'claims' => $request->attributes->get('auth_claims'),
        ]);
    }

    public function logout(): JsonResponse
    {
        return response()->json([
            'message' => 'Sesión de administrador cerrada. Elimina el token admin del frontend.',
            'remove' => ['session_id_admin', 'admin_access_token'],
        ]);
    }
}
