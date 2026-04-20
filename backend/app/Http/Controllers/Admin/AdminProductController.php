<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminProductController extends Controller
{
    public function index(): View
    {
        return view('admin.products.index', [
            'products' => Product::query()->with('catalogCategory')->latest()->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('admin.products.create', [
            'categories' => Category::query()->where('is_active', true)->orderBy('sort_order')->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['slug'] = Str::slug($data['name']).'-'.Str::lower(Str::random(5));

        Product::query()->create($data);

        return redirect()->route('admin.productos.index')->with('status', 'Producto creado correctamente.');
    }

    public function edit(Product $producto): View
    {
        return view('admin.products.edit', [
            'product' => $producto,
            'categories' => Category::query()->where('is_active', true)->orderBy('sort_order')->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Product $producto): RedirectResponse
    {
        $data = $this->validatedData($request);
        $producto->update($data);

        return redirect()->route('admin.productos.index')->with('status', 'Producto actualizado correctamente.');
    }

    public function destroy(Product $producto): RedirectResponse
    {
        $producto->delete();

        return redirect()->route('admin.productos.index')->with('status', 'Producto eliminado correctamente.');
    }

    protected function validatedData(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'cost_price' => ['required', 'numeric', 'min:0'],
            'discount_percent' => ['required', 'numeric', 'min:0', 'max:90'],
            'image' => ['required', 'url'],
            'sizes' => ['required', 'string'],
            'colors' => ['required', 'string'],
            'stock' => ['required', 'integer', 'min:0'],
            'is_featured' => ['nullable', 'boolean'],
        ]);

        $data['sizes'] = array_values(array_filter(array_map('trim', explode(',', $data['sizes']))));
        $data['colors'] = array_values(array_filter(array_map('trim', explode(',', $data['colors']))));
        $data['is_featured'] = $request->boolean('is_featured');
        $data['category'] = Category::query()->findOrFail($data['category_id'])->name;

        return $data;
    }
}
