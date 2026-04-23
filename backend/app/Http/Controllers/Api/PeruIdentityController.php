<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PeruIdentityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PeruIdentityController extends Controller
{
    public function __construct(
        protected PeruIdentityService $peruIdentityService
    ) {}

    public function dni(Request $request): JsonResponse
    {
        $data = $request->validate([
            'dni' => ['required', 'digits:8'],
        ]);

        $result = $this->peruIdentityService->lookupDni($data['dni']);

        if (! $result['success']) {
            return response()->json([
                'message' => $result['message'],
            ], $result['status']);
        }

        return response()->json($result['data']);
    }

    public function ruc(Request $request): JsonResponse
    {
        $data = $request->validate([
            'ruc' => ['required', 'digits:11'],
        ]);

        $result = $this->peruIdentityService->lookupRuc($data['ruc']);

        if (! $result['success']) {
            return response()->json([
                'message' => $result['message'],
            ], $result['status']);
        }

        return response()->json($result['data']);
    }
}
