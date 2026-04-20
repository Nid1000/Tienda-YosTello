<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        $cart = $request->session()->get('cart', []);
        $productIds = array_keys($cart);

        $products = Product::query()
            ->whereIn('id', $productIds)
            ->get()
            ->map(function (Product $product) use ($cart) {
                $product->cart_quantity = $cart[$product->id]['quantity'];
                $product->cart_size = $cart[$product->id]['size'];
                $product->cart_subtotal = $product->final_price * $product->cart_quantity;

                return $product;
            });

        $total = $products->sum(fn (Product $product) => $product->final_price * $product->cart_quantity);

        return view('cart.index', [
            'products' => $products,
            'total' => $total,
            'subtotal' => $total,
            'shippingCost' => 0,
            'itemsCount' => $products->sum('cart_quantity'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1', 'max:10'],
            'size' => ['required', 'string', 'max:20'],
        ]);

        $product = Product::query()->findOrFail($data['product_id']);
        abort_if($product->stock < 1, 422, 'Este producto no tiene stock disponible.');

        $cart = $request->session()->get('cart', []);
        $existing = $cart[$product->id]['quantity'] ?? 0;

        $cart[$product->id] = [
            'quantity' => min($existing + $data['quantity'], 10, $product->stock),
            'size' => $data['size'],
        ];

        $request->session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('status', 'Producto agregado al carrito.');
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:10'],
        ]);

        $cart = $request->session()->get('cart', []);

        if (isset($cart[$product->id])) {
            abort_if($product->stock < 1, 422, 'Este producto ya no tiene stock disponible.');
            $cart[$product->id]['quantity'] = min($data['quantity'], max(1, $product->stock));
            $request->session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('status', 'Carrito actualizado.');
    }

    public function destroy(Request $request, Product $product): RedirectResponse
    {
        $cart = $request->session()->get('cart', []);
        unset($cart[$product->id]);
        $request->session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('status', 'Producto eliminado del carrito.');
    }
}
