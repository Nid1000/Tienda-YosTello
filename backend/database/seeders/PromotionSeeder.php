<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Promotion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PromotionSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::query()->where('name', 'Ropa')->first();

        $promotions = [
            [
                'title' => 'Semana Atelier',
                'description' => 'Una seleccion editorial con descuento para primeras compras y piezas destacadas.',
                'code' => 'ATELIER15',
                'discount_type' => 'percentage',
                'discount_value' => 15,
                'target_type' => 'all',
                'badge_text' => 'Edicion limitada',
                'hero_image' => 'https://images.unsplash.com/photo-1496747611176-843222e1e57c?auto=format&fit=crop&w=1200&q=80',
                'is_active' => true,
            ],
            [
                'title' => 'Ropa de Temporada',
                'description' => 'Impulsa prendas urbanas con una promocion visible desde el storefront.',
                'code' => 'ROPA10',
                'discount_type' => 'percentage',
                'discount_value' => 10,
                'target_type' => 'category',
                'category_id' => $category?->id,
                'badge_text' => 'Capsula urbana',
                'hero_image' => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?auto=format&fit=crop&w=1200&q=80',
                'is_active' => true,
            ],
        ];

        foreach ($promotions as $promotion) {
            Promotion::query()->updateOrCreate(
                ['code' => $promotion['code']],
                [
                    ...$promotion,
                    'slug' => Str::slug($promotion['title']),
                ]
            );
        }
    }
}
