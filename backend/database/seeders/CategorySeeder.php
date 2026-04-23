<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Ropa',
                'description' => 'Prendas urbanas, buzos, chaquetas y piezas para uso diario.',
                'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=900&q=80',
                'sort_order' => 1,
            ],
            [
                'name' => 'Zapatillas',
                'description' => 'Modelos casuales, deportivos y retro para completar tu look.',
                'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=900&q=80',
                'sort_order' => 2,
            ],
            [
                'name' => 'Pantalones',
                'description' => 'Jeans, joggers y pantalones con silueta relajada y moderna.',
                'image' => 'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?auto=format&fit=crop&w=900&q=80',
                'sort_order' => 3,
            ],
            [
                'name' => 'Accesorios',
                'description' => 'Gorras, correas y detalles que completan el look YO-TELLO.',
                'image' => 'https://images.unsplash.com/photo-1523779105320-d1cd346ff52b?auto=format&fit=crop&w=900&q=80',
                'sort_order' => 4,
            ],
            [
                'name' => 'Bolsos',
                'description' => 'Bolsos compactos y mochilas urbanas para llevar lo esencial.',
                'image' => 'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?auto=format&fit=crop&w=900&q=80',
                'sort_order' => 5,
            ],
        ];

        foreach ($categories as $category) {
            Category::query()->updateOrCreate(
                ['name' => $category['name']],
                [
                    ...$category,
                    'slug' => Str::slug($category['name']),
                    'is_active' => true,
                ]
            );
        }
    }
}
