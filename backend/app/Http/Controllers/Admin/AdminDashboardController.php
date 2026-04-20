<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function __invoke(): View
    {
        $products = Product::query()->get();
        $orders = Order::query()->latest()->take(5)->get();
        $startOfWeek = Carbon::now()->startOfWeek();
        $startOfMonthWindow = Carbon::now()->startOfMonth()->subMonths(5);
        $weeklySales = collect(range(0, 6))->map(function (int $offset) use ($startOfWeek) {
            $day = $startOfWeek->copy()->addDays($offset);

            return [
                'label' => $day->translatedFormat('D'),
                'amount' => (float) Order::query()
                    ->whereDate('created_at', $day->toDateString())
                    ->sum('total'),
            ];
        });
        $maxWeeklySales = max(1, (int) ceil($weeklySales->max('amount')));
        $monthlySales = collect(range(0, 5))->map(function (int $offset) use ($startOfMonthWindow) {
            $month = $startOfMonthWindow->copy()->addMonths($offset);

            return [
                'label' => $month->translatedFormat('M'),
                'amount' => (float) Order::query()
                    ->whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->sum('total'),
            ];
        });
        $maxMonthlySales = max(1, (int) ceil($monthlySales->max('amount')));

        return view('admin.index', [
            'stats' => [
                'products' => $products->count(),
                'categories' => Category::query()->count(),
                'users' => User::query()->count(),
                'promotions' => Promotion::query()->count(),
                'active_promotions' => Promotion::query()->active()->count(),
                'discounted_products' => $products->where('discount_percent', '>', 0)->count(),
                'inventory_value' => $products->sum(fn (Product $product) => (float) $product->cost_price * $product->stock),
                'projected_revenue' => $products->sum(fn (Product $product) => $product->final_price * $product->stock),
                'projected_profit' => $products->sum(fn (Product $product) => $product->profit_per_unit * $product->stock),
            ],
            'orders' => $orders,
            'promotions' => Promotion::query()->active()->latest()->take(3)->get(),
            'weeklySales' => $weeklySales,
            'maxWeeklySales' => $maxWeeklySales,
            'monthlySales' => $monthlySales,
            'maxMonthlySales' => $maxMonthlySales,
        ]);
    }
}
