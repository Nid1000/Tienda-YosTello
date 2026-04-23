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
        $categories = Category::query()
            ->withCount('products')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get()
            ->map(function (Category $category) {
                $stock = Product::query()
                    ->where('category_id', $category->id)
                    ->sum('stock');

                return [
                    'name' => $category->name,
                    'products' => $category->products_count,
                    'stock' => (int) $stock,
                ];
            });
        $maxCategoryStock = max(1, (int) $categories->max('stock'));
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
        $hasWeeklySales = $weeklySales->sum('amount') > 0;
        $weeklyPreviewWeights = [0.62, 0.78, 0.54, 0.86, 1, 0.72, 0.48];
        $weeklyChart = $weeklySales->values()->map(function (array $day, int $index) use ($hasWeeklySales, $products, $weeklyPreviewWeights) {
            if ($hasWeeklySales) {
                return $day + ['is_preview' => false];
            }

            $averageFinalPrice = max(1, (float) $products->avg(fn (Product $product) => $product->final_price));

            return [
                'label' => $day['label'],
                'amount' => round($averageFinalPrice * $weeklyPreviewWeights[$index]),
                'is_preview' => true,
            ];
        });
        $maxWeeklySales = max(1, (int) ceil($weeklyChart->max('amount')));
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
            'categoryInventory' => $categories,
            'maxCategoryStock' => $maxCategoryStock,
            'weeklySales' => $weeklySales,
            'weeklyChart' => $weeklyChart,
            'hasWeeklySales' => $hasWeeklySales,
            'maxWeeklySales' => $maxWeeklySales,
            'monthlySales' => $monthlySales,
            'maxMonthlySales' => $maxMonthlySales,
        ]);
    }
}
