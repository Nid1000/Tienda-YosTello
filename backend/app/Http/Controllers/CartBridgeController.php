<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartBridgeController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'target' => ['required', 'string', 'in:checkout,cart'],
            'cart' => ['required', 'string'],
        ]);

        $decoded = json_decode($data['cart'], true);
        $items = is_array($decoded) ? $decoded : [];

        $normalized = [];
        foreach ($items as $item) {
            if (! is_array($item)) {
                continue;
            }

            $productId = isset($item['id']) ? (int) $item['id'] : 0;
            $quantity = isset($item['qty']) ? (int) $item['qty'] : 0;
            $size = isset($item['size']) && is_string($item['size']) ? trim($item['size']) : null;

            if ($productId <= 0 || $quantity <= 0) {
                continue;
            }

            $quantity = max(1, min(10, $quantity));
            $size = $size === '' ? null : $size;
            if (is_string($size) && mb_strlen($size) > 20) {
                $size = mb_substr($size, 0, 20);
            }

            $normalized[$productId] = [
                'quantity' => $quantity,
                'size' => $size ?? 'Unica',
            ];
        }

        if ($normalized !== []) {
            $existingProducts = Product::query()
                ->whereIn('id', array_keys($normalized))
                ->get(['id', 'stock'])
                ->keyBy('id');

            $normalized = array_filter(
                $normalized,
                static fn ($value, $key) => isset($existingProducts[$key]) && $existingProducts[$key]->stock > 0,
                ARRAY_FILTER_USE_BOTH
            );

            foreach ($normalized as $productId => $item) {
                $normalized[$productId]['quantity'] = min($item['quantity'], $existingProducts[$productId]->stock);
            }
        }

        $request->session()->put('cart', $normalized);

        return redirect()->route($data['target'] === 'checkout' ? 'checkout.create' : 'cart.index');
    }
}
