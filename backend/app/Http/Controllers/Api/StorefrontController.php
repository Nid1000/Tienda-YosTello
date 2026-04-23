<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StorefrontController extends Controller
{
    public function overview(): JsonResponse
    {
        $allProducts = Product::query()
            ->with('catalogCategory')
            ->latest()
            ->get()
            ->map(fn (Product $product) => $this->transformProduct($product));

        $featuredProducts = Product::query()
            ->with('catalogCategory')
            ->where('is_featured', true)
            ->latest()
            ->take(4)
            ->get()
            ->map(fn (Product $product) => $this->transformProduct($product));

        $latestProducts = Product::query()
            ->with('catalogCategory')
            ->latest()
            ->take(6)
            ->get()
            ->map(fn (Product $product) => $this->transformProduct($product));

        $categories = Category::query()
            ->where('is_active', true)
            ->withCount('products')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get()
            ->map(fn ($category) => [
                'name' => $category->name,
                'slug' => $category->slug,
                'image' => $category->image,
                'total' => (int) $category->products_count,
            ]);

        $promotions = Promotion::query()
            ->active()
            ->with(['category', 'product'])
            ->latest()
            ->take(3)
            ->get()
            ->map(fn (Promotion $promotion) => [
                'title' => $promotion->title,
                'description' => $promotion->description,
                'code' => $promotion->code,
                'discount_label' => $promotion->discount_label,
                'target_label' => $promotion->target_label,
                'badge_text' => $promotion->badge_text,
                'hero_image' => $promotion->hero_image,
            ]);

        return response()->json([
            'brand' => 'YO-TELLO',
            'headline' => 'Moda editorial conectada a un backend real.',
            'description' => 'Una experiencia premium de catalogo, promociones, carrito y administracion.',
            'stats' => [
                'products' => $allProducts->count(),
                'featured' => Product::query()->where('is_featured', true)->count(),
                'categories' => $categories->count(),
                'stock' => Product::query()->sum('stock'),
                'discounted' => Product::query()->where('discount_percent', '>', 0)->count(),
            ],
            'categories' => $categories,
            'promotions' => $promotions,
            'allProducts' => $allProducts,
            'featuredProducts' => $featuredProducts,
            'latestProducts' => $latestProducts,
        ]);
    }

    public function products(Request $request): JsonResponse
    {
        $query = Product::query()
            ->with('catalogCategory')
            ->when(
                $request->filled('category'),
                fn ($builder) => $builder->where(function ($nested) use ($request): void {
                    $selected = $request->string('category')->toString();
                    $nested
                        ->where('category', $selected)
                        ->orWhereHas('catalogCategory', fn ($categoryQuery) => $categoryQuery->where('slug', $selected)->orWhere('name', $selected));
                })
            )
            ->when(
                $request->filled('search'),
                fn ($builder) => $builder->where(function ($nested) use ($request): void {
                    $term = $request->string('search')->toString();
                    $nested
                        ->where('name', 'like', "%{$term}%")
                        ->orWhere('description', 'like', "%{$term}%");
                })
            )
            ->latest();

        $products = $query
            ->take((int) min(max($request->integer('limit', 12), 1), 24))
            ->get()
            ->map(fn (Product $product) => $this->transformProduct($product));

        return response()->json([
            'items' => $products,
        ]);
    }

    protected function transformProduct(Product $product): array
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'category' => $product->category_name,
            'description' => $product->description,
            'price' => (float) $product->price,
            'final_price' => $product->final_price,
            'cost_price' => (float) $product->cost_price,
            'discount_percent' => (float) $product->discount_percent,
            'profit_per_unit' => $product->profit_per_unit,
            'image' => $product->image,
            'sizes' => $product->sizes ?? [],
            'colors' => $product->colors ?? [],
            'stock' => $product->stock,
            'is_featured' => $product->is_featured,
        ];
    }
}
