<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminOrderController extends Controller
{
    public const STATUSES = [
        'pendiente' => 'Pendiente',
        'confirmado' => 'Confirmado',
        'preparando' => 'Preparando',
        'enviado' => 'Enviado',
        'entregado' => 'Entregado',
        'cancelado' => 'Cancelado',
    ];

    public function index(): View
    {
        return view('admin.orders.index', [
            'orders' => Order::query()
                ->with(['user', 'items'])
                ->latest()
                ->paginate(12),
            'statuses' => self::STATUSES,
        ]);
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(array_keys(self::STATUSES))],
        ]);

        $order->update($data);

        return redirect()
            ->route('admin.pedidos.index')
            ->with('status', "Pedido #{$order->id} actualizado correctamente.");
    }
}
