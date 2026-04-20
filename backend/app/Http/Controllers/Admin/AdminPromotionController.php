<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminPromotionController extends Controller
{
    public function index(): View
    {
        return view('admin.promotions.index', [
            'promotions' => Promotion::query()
                ->with(['category', 'product'])
                ->latest()
                ->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('admin.promotions.create', $this->formData());
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['slug'] = Str::slug($data['title']).'-'.Str::lower(Str::random(4));

        Promotion::query()->create($data);

        return redirect()->route('admin.promociones.index')->with('status', 'Promocion creada correctamente.');
    }

    public function edit(Promotion $promocione): View
    {
        return view('admin.promotions.edit', [
            ...$this->formData(),
            'promotion' => $promocione,
        ]);
    }

    public function update(Request $request, Promotion $promocione): RedirectResponse
    {
        $promocione->update($this->validatedData($request));

        return redirect()->route('admin.promociones.index')->with('status', 'Promocion actualizada correctamente.');
    }

    public function destroy(Promotion $promocione): RedirectResponse
    {
        $promocione->delete();

        return redirect()->route('admin.promociones.index')->with('status', 'Promocion eliminada correctamente.');
    }

    protected function formData(): array
    {
        return [
            'categories' => Category::query()->orderBy('sort_order')->orderBy('name')->get(),
            'products' => Product::query()->orderBy('name')->get(),
        ];
    }

    protected function validatedData(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'code' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('promotions', 'code')->ignore($request->route('promocione')),
            ],
            'discount_type' => ['required', 'string', 'in:percentage,fixed'],
            'discount_value' => ['required', 'numeric', 'min:0'],
            'target_type' => ['required', 'string', 'in:all,category,product'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'product_id' => ['nullable', 'exists:products,id'],
            'badge_text' => ['nullable', 'string', 'max:80'],
            'hero_image' => ['nullable', 'url'],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($data['discount_type'] === 'percentage') {
            $request->validate(['discount_value' => ['max:90']]);
        }

        if ($data['target_type'] !== 'category') {
            $data['category_id'] = null;
        }

        if ($data['target_type'] !== 'product') {
            $data['product_id'] = null;
        }

        $data['code'] = isset($data['code']) && $data['code'] !== '' ? Str::upper($data['code']) : null;
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
