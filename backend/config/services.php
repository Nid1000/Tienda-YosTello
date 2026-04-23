<?php

return [
    'peru_identity' => [
        'provider' => env('PERU_IDENTITY_PROVIDER', 'apiperu'),
        'fallback_provider' => env('PERU_IDENTITY_FALLBACK_PROVIDER'),
        'apiperu' => [
            'base_url' => env('PERU_API_BASE_URL', 'https://apiperu.dev/api'),
            'token' => env('PERU_API_TOKEN'),
        ],
        'apisnet' => [
            'base_url' => env('APISNET_BASE_URL', 'https://api.decolecta.com/v1'),
            'token' => env('APISNET_TOKEN'),
            'dni_referer' => env('APISNET_DNI_REFERER', 'https://apis.net.pe/consulta-dni-api'),
            'ruc_referer' => env('APISNET_RUC_REFERER', 'https://apis.net.pe/api-ruc'),
        ],
    ],
];
