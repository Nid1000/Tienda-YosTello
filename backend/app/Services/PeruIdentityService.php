<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PeruIdentityService
{
    public function lookupDni(string $dni): array
    {
        $baseUrl = rtrim((string) config('services.peru_api.base_url'), '/');
        $token = (string) config('services.peru_api.token');

        if ($baseUrl === '' || $token === '') {
            return [
                'success' => false,
                'status' => 500,
                'message' => 'Configura PERU_API_BASE_URL y PERU_API_TOKEN en tu archivo .env.',
            ];
        }

        $response = Http::acceptJson()
            ->withToken($token)
            ->post($baseUrl.'/dni', [
                'dni' => $dni,
            ]);

        if ($response->failed()) {
            return [
                'success' => false,
                'status' => $response->status() ?: 422,
                'message' => 'No se pudo consultar el DNI en este momento.',
            ];
        }

        $payload = $response->json();
        $data = $payload['data'] ?? [];

        return [
            'success' => true,
            'status' => 200,
            'data' => [
                'document_number' => $dni,
                'first_name' => $data['nombres'] ?? '',
                'last_name' => trim(($data['apellido_paterno'] ?? '').' '.($data['apellido_materno'] ?? '')),
                'full_name' => $data['nombre_completo'] ?? trim(($data['nombres'] ?? '').' '.($data['apellido_paterno'] ?? '').' '.($data['apellido_materno'] ?? '')),
                'raw' => $data,
            ],
        ];
    }
}
