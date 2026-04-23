<?php

namespace App\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use InvalidArgumentException;

class JwtService
{
    public function encode(array $claims, ?Carbon $expiresAt = null): string
    {
        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT',
        ];

        $payload = [
            ...$claims,
            'iat' => now()->timestamp,
            'exp' => ($expiresAt ?? now()->addHours(8))->timestamp,
            'iss' => Config::get('app.url'),
        ];

        $segments = [
            $this->base64UrlEncode(json_encode($header, JSON_THROW_ON_ERROR)),
            $this->base64UrlEncode(json_encode($payload, JSON_THROW_ON_ERROR)),
        ];

        $segments[] = $this->sign(implode('.', $segments));

        return implode('.', $segments);
    }

    public function decode(string $token): array
    {
        $parts = explode('.', $token);

        if (count($parts) !== 3) {
            throw new InvalidArgumentException('Token JWT invalido.');
        }

        [$header, $payload, $signature] = $parts;
        $expectedSignature = $this->sign($header.'.'.$payload);

        if (! hash_equals($expectedSignature, $signature)) {
            throw new InvalidArgumentException('Firma JWT invalida.');
        }

        $claims = json_decode($this->base64UrlDecode($payload), true, 512, JSON_THROW_ON_ERROR);

        if (($claims['exp'] ?? 0) < now()->timestamp) {
            throw new InvalidArgumentException('Token JWT expirado.');
        }

        return $claims;
    }

    protected function sign(string $value): string
    {
        return $this->base64UrlEncode(hash_hmac('sha256', $value, $this->secret(), true));
    }

    protected function secret(): string
    {
        $key = (string) Config::get('app.key');

        if (str_starts_with($key, 'base64:')) {
            return base64_decode(substr($key, 7), true) ?: $key;
        }

        return $key;
    }

    protected function base64UrlEncode(string $value): string
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }

    protected function base64UrlDecode(string $value): string
    {
        return base64_decode(strtr($value, '-_', '+/').str_repeat('=', (4 - strlen($value) % 4) % 4));
    }
}
