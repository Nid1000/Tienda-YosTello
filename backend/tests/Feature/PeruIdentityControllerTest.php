<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PeruIdentityControllerTest extends TestCase
{
    public function test_dni_endpoint_normalizes_apiperu_response(): void
    {
        config([
            'services.peru_identity.provider' => 'apiperu',
            'services.peru_identity.fallback_provider' => null,
            'services.peru_identity.apiperu.base_url' => 'https://apiperu.dev/api',
            'services.peru_identity.apiperu.token' => 'token-real-de-prueba',
        ]);

        Http::fake([
            'https://apiperu.dev/api/dni' => Http::response([
                'success' => true,
                'data' => [
                    'numero' => '12345678',
                    'nombre_completo' => 'PEREZ LOPEZ JUAN',
                    'nombres' => 'JUAN',
                    'apellido_paterno' => 'PEREZ',
                    'apellido_materno' => 'LOPEZ',
                ],
            ]),
        ]);

        $response = $this->postJson('/api/v1/peru/dni', [
            'dni' => '12345678',
        ]);

        $response
            ->assertOk()
            ->assertJson([
                'document_number' => '12345678',
                'first_name' => 'JUAN',
                'last_name' => 'PEREZ LOPEZ',
                'full_name' => 'PEREZ LOPEZ JUAN',
                'provider' => 'apiperu',
            ]);
    }

    public function test_ruc_endpoint_normalizes_apiperu_response(): void
    {
        config([
            'services.peru_identity.provider' => 'apiperu',
            'services.peru_identity.fallback_provider' => null,
            'services.peru_identity.apiperu.base_url' => 'https://apiperu.dev/api',
            'services.peru_identity.apiperu.token' => 'token-real-de-prueba',
        ]);

        Http::fake([
            'https://apiperu.dev/api/ruc' => Http::response([
                'success' => true,
                'data' => [
                    'ruc' => '20123456789',
                    'nombre_o_razon_social' => 'EMPRESA DEMO SAC',
                    'direccion' => 'AV. DEMO 123',
                    'direccion_completa' => 'AV. DEMO 123 - LIMA LIMA LIMA',
                    'departamento' => 'LIMA',
                    'provincia' => 'LIMA',
                    'distrito' => 'LIMA',
                ],
            ]),
        ]);

        $response = $this->postJson('/api/v1/peru/ruc', [
            'ruc' => '20123456789',
        ]);

        $response
            ->assertOk()
            ->assertJson([
                'document_number' => '20123456789',
                'business_name' => 'EMPRESA DEMO SAC',
                'shipping_address' => 'AV. DEMO 123 - LIMA LIMA LIMA',
                'department' => 'LIMA',
                'province' => 'LIMA',
                'district' => 'LIMA',
                'provider' => 'apiperu',
            ]);
    }

    public function test_placeholder_tokens_do_not_count_as_real_configuration(): void
    {
        config([
            'services.peru_identity.provider' => 'apiperu',
            'services.peru_identity.fallback_provider' => 'apisnet',
            'services.peru_identity.apiperu.token' => 'TU_TOKEN_REAL_APIPERU',
            'services.peru_identity.apisnet.token' => 'TU_TOKEN_REAL_APISNET',
        ]);

        Http::fake();

        $response = $this->postJson('/api/v1/peru/dni', [
            'dni' => '12345678',
        ]);

        $response
            ->assertStatus(500)
            ->assertJson([
                'message' => 'La busqueda por DNI o RUC no esta disponible todavia. Configura un token real del proveedor en backend/.env y reinicia Laravel.',
            ]);

        Http::assertNothingSent();
    }

    public function test_apiperu_success_false_payload_is_returned_as_error(): void
    {
        config([
            'services.peru_identity.provider' => 'apiperu',
            'services.peru_identity.fallback_provider' => null,
            'services.peru_identity.apiperu.base_url' => 'https://apiperu.dev/api',
            'services.peru_identity.apiperu.token' => 'token-real-de-prueba',
        ]);

        Http::fake([
            'https://apiperu.dev/api/dni' => Http::response([
                'success' => false,
                'message' => 'No se encontro informacion para el DNI enviado.',
            ], 200),
        ]);

        $response = $this->postJson('/api/v1/peru/dni', [
            'dni' => '12345678',
        ]);

        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => 'No se encontro informacion para el DNI enviado.',
            ]);
    }
}
