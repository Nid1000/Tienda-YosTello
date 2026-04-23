<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class PeruIdentityService
{
    public function isConfigured(): bool
    {
        foreach ($this->providerSequence() as $provider) {
            if ($this->providerIsConfigured($provider)) {
                return true;
            }
        }

        return false;
    }

    public function missingConfigurationMessage(): string
    {
        return 'La busqueda por DNI o RUC no esta disponible todavia. Configura un token real del proveedor en backend/.env y reinicia Laravel.';
    }

    public function lookupDni(string $dni): array
    {
        $response = $this->request('dni', $dni);

        if (! $response['success']) {
            return $response;
        }

        $data = $response['data'];

        return [
            'success' => true,
            'status' => 200,
            'data' => [
                'document_number' => $dni,
                'first_name' => $data['first_name'] ?? '',
                'last_name' => $data['last_name'] ?? '',
                'full_name' => $data['full_name'] ?? trim(($data['first_name'] ?? '').' '.($data['last_name'] ?? '')),
                'raw' => $data['raw'] ?? [],
                'provider' => $response['provider'],
            ],
        ];
    }

    public function lookupRuc(string $ruc): array
    {
        $response = $this->request('ruc', $ruc);

        if (! $response['success']) {
            return $response;
        }

        $data = $response['data'];
        $businessName = trim((string) ($data['business_name'] ?? ''));

        return [
            'success' => true,
            'status' => 200,
            'data' => [
                'document_number' => $ruc,
                'first_name' => $businessName,
                'last_name' => 'RUC',
                'full_name' => $businessName,
                'business_name' => $businessName,
                'shipping_address' => $data['shipping_address'] ?? '',
                'department' => $data['department'] ?? '',
                'province' => $data['province'] ?? '',
                'district' => $data['district'] ?? '',
                'raw' => $data['raw'] ?? [],
                'provider' => $response['provider'],
            ],
        ];
    }

    protected function request(string $documentType, string $number): array
    {
        $providers = array_values(array_filter(
            $this->providerSequence(),
            fn (string $provider): bool => $this->providerIsConfigured($provider)
        ));

        $attemptedProviders = [];
        $providerFailures = [];

        foreach ($providers as $index => $provider) {
            $attemptedProviders[] = $provider;

            $result = match ($provider) {
                'apiperu' => $this->requestApiperu($documentType, $number),
                'apisnet' => $this->requestApisNet($documentType, $number),
                default => [
                    'success' => false,
                    'status' => 500,
                    'message' => "El proveedor {$provider} no esta soportado.",
                ],
            };

            if ($result['success']) {
                return [
                    ...$result,
                    'provider' => $provider,
                ];
            }

            $providerFailures[] = [
                'provider' => $provider,
                'status' => $result['status'],
                'message' => $result['message'],
            ];

            $hasMoreProviders = isset($providers[$index + 1]);

            if (! $hasMoreProviders) {
                return [
                    ...$result,
                    'provider' => $provider,
                ];
            }

            if (! $this->shouldFallback($result['status'])) {
                return [
                    ...$result,
                    'provider' => $provider,
                ];
            }
        }

        if ($attemptedProviders === []) {
            return [
                'success' => false,
                'status' => 500,
                'message' => $this->missingConfigurationMessage(),
            ];
        }

        return [
            'success' => false,
            'status' => $this->resolveFinalStatus($providerFailures),
            'message' => $this->buildFallbackFailureMessage($providerFailures, strtoupper($documentType)),
        ];
    }

    protected function requestApiperu(string $documentType, string $number): array
    {
        $baseUrl = rtrim((string) config('services.peru_identity.apiperu.base_url'), '/');
        $token = trim((string) config('services.peru_identity.apiperu.token'));
        $endpoint = $documentType === 'dni' ? 'dni' : 'ruc';
        $field = $documentType === 'dni' ? 'dni' : 'ruc';

        try {
            $response = Http::acceptJson()
                ->asJson()
                ->withToken($token)
                ->timeout(15)
                ->post($baseUrl.'/'.$endpoint, [
                    $field => $number,
                ]);
        } catch (ConnectionException) {
            return $this->connectionFailedResponse(strtoupper($documentType));
        }

        return $this->normalizeApiperuResponse($response, $documentType);
    }

    protected function requestApisNet(string $documentType, string $number): array
    {
        $baseUrl = rtrim((string) config('services.peru_identity.apisnet.base_url'), '/');
        $token = trim((string) config('services.peru_identity.apisnet.token'));
        $endpoint = $documentType === 'dni' ? 'reniec/dni' : 'sunat/ruc';
        $referer = $documentType === 'dni'
            ? (string) config('services.peru_identity.apisnet.dni_referer')
            : (string) config('services.peru_identity.apisnet.ruc_referer');

        try {
            $response = Http::acceptJson()
                ->withToken($token)
                ->withHeaders([
                    'Referer' => $referer,
                    'User-Agent' => 'laravel-http-client',
                ])
                ->timeout(15)
                ->get($baseUrl.'/'.$endpoint, [
                    'numero' => $number,
                ]);
        } catch (ConnectionException) {
            return $this->connectionFailedResponse(strtoupper($documentType));
        }

        return $this->normalizeApisNetResponse($response, $documentType);
    }

    protected function normalizeApiperuResponse(Response $response, string $documentType): array
    {
        if ($response->failed()) {
            return $this->failedResponse($response, strtoupper($documentType));
        }

        $payload = $response->json();

        if (! is_array($payload)) {
            return [
                'success' => false,
                'status' => 502,
                'message' => 'El proveedor actual devolvio una respuesta invalida.',
            ];
        }

        if (($payload['success'] ?? true) !== true) {
            return [
                'success' => false,
                'status' => $this->resolvePayloadStatus($payload),
                'message' => $this->resolvePayloadMessage($payload, strtoupper($documentType)),
            ];
        }

        $data = is_array($payload['data'] ?? null) ? $payload['data'] : [];

        if ($documentType === 'dni') {
            return [
                'success' => true,
                'status' => 200,
                'data' => [
                    'first_name' => $data['nombres'] ?? '',
                    'last_name' => trim(($data['apellido_paterno'] ?? '').' '.($data['apellido_materno'] ?? '')),
                    'full_name' => $data['nombre_completo'] ?? trim(($data['nombres'] ?? '').' '.($data['apellido_paterno'] ?? '').' '.($data['apellido_materno'] ?? '')),
                    'raw' => $data,
                ],
            ];
        }

        return [
            'success' => true,
            'status' => 200,
            'data' => [
                'business_name' => trim((string) ($data['nombre_o_razon_social'] ?? '')),
                'shipping_address' => trim((string) ($data['direccion_completa'] ?? $data['direccion'] ?? '')),
                'department' => trim((string) ($data['departamento'] ?? '')),
                'province' => trim((string) ($data['provincia'] ?? '')),
                'district' => trim((string) ($data['distrito'] ?? '')),
                'raw' => $data,
            ],
        ];
    }

    protected function normalizeApisNetResponse(Response $response, string $documentType): array
    {
        if ($response->failed()) {
            return $this->failedResponse($response, strtoupper($documentType));
        }

        $data = $response->json() ?? [];

        if ($documentType === 'dni') {
            return [
                'success' => true,
                'status' => 200,
                'data' => [
                    'first_name' => trim((string) ($data['nombres'] ?? '')),
                    'last_name' => trim((string) (($data['apellidoPaterno'] ?? '').' '.($data['apellidoMaterno'] ?? ''))),
                    'full_name' => trim((string) ($data['nombre'] ?? '')),
                    'raw' => $data,
                ],
            ];
        }

        return [
            'success' => true,
            'status' => 200,
            'data' => [
                'business_name' => trim((string) ($data['razonSocial'] ?? $data['nombre'] ?? '')),
                'shipping_address' => trim((string) ($data['direccion'] ?? '')),
                'department' => trim((string) ($data['departamento'] ?? '')),
                'province' => trim((string) ($data['provincia'] ?? '')),
                'district' => trim((string) ($data['distrito'] ?? '')),
                'raw' => $data,
            ],
        ];
    }

    protected function failedResponse(Response $response, string $documentLabel): array
    {
        $payload = $response->json();
        $apiMessage = is_array($payload)
            ? trim((string) ($payload['message'] ?? $payload['error'] ?? ''))
            : '';

        $message = "No se pudo consultar el {$documentLabel} en este momento.";

        if (in_array($response->status(), [401, 403], true)) {
            $message = 'El token configurado no es valido o ya no tiene acceso en el proveedor actual.';
        } elseif ($apiMessage !== '') {
            $message = $apiMessage;
        }

        return [
            'success' => false,
            'status' => $response->status() ?: 422,
            'message' => $message,
        ];
    }

    protected function connectionFailedResponse(string $documentLabel): array
    {
        return [
            'success' => false,
            'status' => 503,
            'message' => "No se pudo conectar con el proveedor para consultar el {$documentLabel}.",
        ];
    }

    protected function buildFallbackFailureMessage(array $providerFailures, string $documentLabel): string
    {
        if ($providerFailures === []) {
            return "No se pudo consultar el {$documentLabel} con los proveedores configurados.";
        }

        $messages = array_map(function (array $failure): string {
            $provider = strtoupper((string) ($failure['provider'] ?? 'proveedor'));
            $message = trim((string) ($failure['message'] ?? 'Error desconocido.'));

            return "{$provider}: {$message}";
        }, $providerFailures);

        return 'No se pudo completar la consulta. '.implode(' | ', $messages);
    }

    protected function resolveFinalStatus(array $providerFailures): int
    {
        foreach ($providerFailures as $failure) {
            if (($failure['status'] ?? null) === 401 || ($failure['status'] ?? null) === 403) {
                return 401;
            }
        }

        foreach ($providerFailures as $failure) {
            if (($failure['status'] ?? null) === 503) {
                return 503;
            }
        }

        return 503;
    }

    protected function providerSequence(): array
    {
        $primary = trim((string) config('services.peru_identity.provider', 'apiperu'));
        $fallback = trim((string) config('services.peru_identity.fallback_provider', ''));

        return array_values(array_unique(array_filter([$primary, $fallback])));
    }

    protected function providerIsConfigured(string $provider): bool
    {
        return match ($provider) {
            'apiperu' => $this->hasUsableToken((string) config('services.peru_identity.apiperu.token')),
            'apisnet' => $this->hasUsableToken((string) config('services.peru_identity.apisnet.token')),
            default => false,
        };
    }

    protected function shouldFallback(int $status): bool
    {
        return in_array($status, [401, 403, 404, 422, 429, 500, 502, 503, 504], true);
    }

    protected function hasUsableToken(string $token): bool
    {
        $normalized = trim($token);

        if ($normalized === '') {
            return false;
        }

        $placeholders = [
            'TU_TOKEN_REAL_APIPERU',
            'TU_TOKEN_REAL_APISNET',
            '<token>',
            'INGRESAR_TOKEN_AQUI',
        ];

        if (in_array($normalized, $placeholders, true)) {
            return false;
        }

        return ! str_starts_with($normalized, 'TU_TOKEN_');
    }

    protected function resolvePayloadStatus(array $payload): int
    {
        $status = (int) ($payload['status'] ?? 0);

        if ($status >= 400) {
            return $status;
        }

        return 422;
    }

    protected function resolvePayloadMessage(array $payload, string $documentLabel): string
    {
        $message = trim((string) ($payload['message'] ?? $payload['error'] ?? ''));

        if ($message !== '') {
            return $message;
        }

        return "No se pudo consultar el {$documentLabel} en este momento.";
    }
}
