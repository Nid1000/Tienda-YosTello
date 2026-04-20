<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminCategoryController extends Controller
{
    public function index(): View
    {
        return view('admin.categories.index', [
            'categories' => Category::query()
                ->withCount('products')
                ->orderBy('sort_order')
                ->orderBy('name')
                ->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['slug'] = Str::slug($data['name']);

        Category::query()->create($data);

        return redirect()->route('admin.categorias.index')->with('status', 'Categoria creada correctamente.');
    }

    public function edit(Category $categoria): View
    {
        return view('admin.categories.edit', [
            'category' => $categoria,
        ]);
    }

    public function update(Request $request, Category $categoria): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['slug'] = Str::slug($data['name']);

        $categoria->update($data);

        return redirect()->route('admin.categorias.index')->with('status', 'Categoria actualizada correctamente.');
    }

    public function destroy(Category $categoria): RedirectResponse
    {
        $categoria->delete();

        return redirect()->route('admin.categorias.index')->with('status', 'Categoria eliminada correctamente.');
    }

    protected function validatedData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'url'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]) + [
            'is_active' => $request->boolean('is_active'),
        ];
    }
}
