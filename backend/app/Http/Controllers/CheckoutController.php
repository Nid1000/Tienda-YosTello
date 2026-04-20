<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Services\PeruIdentityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(
        protected PeruIdentityService $peruIdentityService
    ) {}

    public function create(Request $request): View
    {
        $cart = $request->session()->get('cart', []);
        $products = Product::query()->whereIn('id', array_keys($cart))->get();
        $total = $products->sum(fn (Product $product) => $product->final_price * ($cart[$product->id]['quantity'] ?? 0));

        return view('checkout.create', [
            'products' => $products,
            'cart' => $cart,
            'total' => $total,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'customer_first_name' => ['required', 'string', 'max:255'],
            'customer_last_name' => ['required', 'string', 'max:255'],
            'document_type' => ['required', 'string', 'in:DNI,CE'],
            'document_number' => ['required', 'string', 'max:20'],
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:30'],
            'shipping_address' => ['required', 'string', 'max:500'],
            'shipping_reference' => ['nullable', 'string', 'max:255'],
            'delivery_method' => ['required', 'string', 'in:domicilio,recojo'],
            'department' => ['required', 'string', 'max:255'],
            'province' => ['required', 'string', 'max:255'],
            'district' => ['required', 'string', 'max:255'],
            'payment_method' => ['required', 'string', 'max:50'],
        ]);

        $cart = $request->session()->get('cart', []);
        abort_if(empty($cart), 422, 'El carrito esta vacio.');

        $products = Product::query()->whereIn('id', array_keys($cart))->get();
        $total = $products->sum(fn (Product $product) => $product->final_price * ($cart[$product->id]['quantity'] ?? 0));

        foreach ($products as $product) {
            $quantity = $cart[$product->id]['quantity'] ?? 0;
            abort_if($quantity > $product->stock, 422, "No hay stock suficiente para {$product->name}.");
        }

        DB::transaction(function () use ($request, $data, $products, $cart, $total): void {
            $order = Order::query()->create([
                'user_id' => $request->user()->id,
                'customer_first_name' => $data['customer_first_name'],
                'customer_last_name' => $data['customer_last_name'],
                'document_type' => $data['document_type'],
                'document_number' => $data['document_number'],
                'customer_name' => $data['customer_name'],
                'customer_phone' => $data['customer_phone'],
                'shipping_address' => $data['shipping_address'],
                'shipping_reference' => $data['shipping_reference'] ?? null,
                'delivery_method' => $data['delivery_method'],
                'department' => $data['department'],
                'province' => $data['province'],
                'district' => $data['district'],
                'payment_method' => $data['payment_method'],
                'status' => 'pendiente',
                'total' => $total,
            ]);

            foreach ($products as $product) {
                $quantity = $cart[$product->id]['quantity'];

                $order->items()->create([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'unit_price' => $product->final_price,
                    'quantity' => $quantity,
                    'selected_size' => $cart[$product->id]['size'],
                    'subtotal' => $product->final_price * $quantity,
                ]);

                $product->decrement('stock', $quantity);
            }
        });

        $request->session()->forget('cart');

        return redirect()->route('orders.index')->with('status', 'Pedido creado correctamente.');
    }

    public function lookupDni(Request $request): JsonResponse
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
}
