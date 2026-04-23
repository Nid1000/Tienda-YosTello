<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\JwtService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClientAuthController extends Controller
{
    public function login(Request $request, JwtService $jwt): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::query()
            ->where('email', $credentials['email'])
            ->where('role', 'customer')
            ->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'message' => 'Credenciales de cliente no validas.',
            ], 422);
        }

        return response()->json([
            'token_type' => 'Bearer',
            'access_token' => $jwt->encode([
                'id' => $user->id,
                'role' => 'customer',
                'context' => 'store',
                'email' => $user->email,
            ]),
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => 'customer',
            ],
        ]);
    }

    public function me(Request $request): JsonResponse
    {
        $user = $request->attributes->get('auth_actor');

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => 'customer',
            ],
            'claims' => $request->attributes->get('auth_claims'),
        ]);
    }

    public function logout(): JsonResponse
    {
        return response()->json([
            'message' => 'Sesion cliente cerrada. Elimina el token cliente del frontend.',
            'remove' => ['session_id_client', 'client_access_token'],
        ]);
    }
}
