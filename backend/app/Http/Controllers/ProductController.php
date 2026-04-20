<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $sort = $request->string('sort')->toString();

        $query = Product::query()
            ->with('catalogCategory')
            ->when(
                $request->filled('category'),
                fn ($query) => $query->where(function ($builder) use ($request): void {
                    $selected = $request->string('category')->toString();
                    $builder
                        ->where('category', $selected)
                        ->orWhereHas('catalogCategory', fn ($categoryQuery) => $categoryQuery->where('slug', $selected)->orWhere('name', $selected));
                })
            )
            ->when(
                $request->filled('search'),
                fn ($query) => $query->where(function ($builder) use ($request) {
                    $term = $request->string('search')->toString();

                    $builder
                        ->where('name', 'like', "%{$term}%")
                        ->orWhere('description', 'like', "%{$term}%");
                })
            );

        $products = (clone $query)
            ->when($sort === 'price_asc', fn ($builder) => $builder->orderBy('price'))
            ->when($sort === 'price_desc', fn ($builder) => $builder->orderByDesc('price'))
            ->when($sort === 'name_asc', fn ($builder) => $builder->orderBy('name'))
            ->when($sort === '' || $sort === 'latest', fn ($builder) => $builder->latest())
            ->paginate(9)
            ->withQueryString();

        $categories = Category::query()
            ->where('is_active', true)
            ->withCount('products')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('products.index', [
            'products' => $products,
            'categories' => $categories,
            'selectedCategory' => $request->string('category')->toString(),
            'search' => $request->string('search')->toString(),
            'sort' => $sort === '' ? 'latest' : $sort,
            'resultsCount' => $products->total(),
        ]);
    }

    public function show(Product $product): View
    {
        $relatedProducts = Product::query()
            ->with('catalogCategory')
            ->where(function ($query) use ($product): void {
                $query
                    ->when($product->category_id, fn ($builder) => $builder->where('category_id', $product->category_id))
                    ->orWhere('category', $product->category);
            })
            ->whereKeyNot($product->id)
            ->take(3)
            ->get();

        return view('products.show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }
}
