<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(Request $request): View
    {
        $featuredProducts = Product::query()
            ->with('catalogCategory')
            ->where('is_featured', true)
            ->latest()
            ->take(6)
            ->get();

        $categories = Category::query()
            ->where('is_active', true)
            ->withCount('products')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $latestProducts = Product::query()
            ->with('catalogCategory')
            ->latest()
            ->take(4)
            ->get();

        $stats = [
            'products' => Product::query()->count(),
            'featured' => Product::query()->where('is_featured', true)->count(),
            'categories' => $categories->count(),
            'stock' => Product::query()->sum('stock'),
            'discounted' => Product::query()->where('discount_percent', '>', 0)->count(),
        ];

        $cartCount = collect($request->session()->get('cart', []))->sum('quantity');
        $cartTotal = Product::query()
            ->whereIn('id', array_keys($request->session()->get('cart', [])))
            ->get()
            ->sum(fn (Product $product) => $product->final_price * ($request->session()->get("cart.{$product->id}.quantity", 0)));

        $userSummary = null;
        $recentOrders = collect();
        $latestProduct = Product::query()->latest()->first();
        $featuredProduct = $featuredProducts->first();

        if ($request->user()) {
            $latestOrder = $request->user()
                ->orders()
                ->latest()
                ->first();

            $recentOrders = $request->user()
                ->orders()
                ->with('items')
                ->latest()
                ->take(3)
                ->get();

            $userSummary = [
                'name' => $request->user()->name,
                'email' => $request->user()->email,
                'role' => $request->user()->isAdmin() ? 'Administrador' : 'Cliente',
                'orders_count' => $request->user()->orders()->count(),
                'latest_order_status' => $latestOrder?->status ?? 'sin pedidos',
            ];
        }

        return view('home', [
            'featuredProducts' => $featuredProducts,
            'categories' => $categories,
            'latestProducts' => $latestProducts,
            'stats' => $stats,
            'cartCount' => $cartCount,
            'cartTotal' => $cartTotal,
            'userSummary' => $userSummary,
            'recentOrders' => $recentOrders,
            'latestProduct' => $latestProduct,
            'featuredProduct' => $featuredProduct,
        ]);
    }
}
