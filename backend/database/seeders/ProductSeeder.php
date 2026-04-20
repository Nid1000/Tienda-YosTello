<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Chaqueta Urbana Classic',
                'slug' => 'chaqueta-urbana-classic',
                'category' => 'Ropa',
                'description' => 'Chaqueta ligera para uso diario con corte moderno y tejido resistente.',
                'price' => 189900,
                'cost_price' => 98000,
                'discount_percent' => 10,
                'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=900&q=80',
                'sizes' => ['S', 'M', 'L', 'XL'],
                'colors' => ['Negro', 'Beige'],
                'stock' => 12,
                'is_featured' => true,
            ],
            [
                'name' => 'Zapatillas Runner Flex',
                'slug' => 'zapatillas-runner-flex',
                'category' => 'Zapatillas',
                'description' => 'Amortiguacion suave, suela flexible y estilo deportivo para todo el dia.',
                'price' => 249900,
                'cost_price' => 145000,
                'discount_percent' => 12,
                'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=900&q=80',
                'sizes' => ['38', '39', '40', '41', '42'],
                'colors' => ['Blanco', 'Rojo'],
                'stock' => 18,
                'is_featured' => true,
            ],
            [
                'name' => 'Pantalon Denim Straight',
                'slug' => 'pantalon-denim-straight',
                'category' => 'Pantalones',
                'description' => 'Jean recto de tiro medio con acabado limpio y ajuste comodo.',
                'price' => 159900,
                'cost_price' => 82000,
                'discount_percent' => 0,
                'image' => 'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?auto=format&fit=crop&w=900&q=80',
                'sizes' => ['30', '32', '34', '36'],
                'colors' => ['Azul', 'Gris'],
                'stock' => 22,
                'is_featured' => true,
            ],
            [
                'name' => 'Buzo Minimal Soft',
                'slug' => 'buzo-minimal-soft',
                'category' => 'Ropa',
                'description' => 'Buzo suave con interior afelpado ideal para climas frescos.',
                'price' => 129900,
                'cost_price' => 64000,
                'discount_percent' => 8,
                'image' => 'https://images.unsplash.com/photo-1512436991641-6745cdb1723f?auto=format&fit=crop&w=900&q=80',
                'sizes' => ['S', 'M', 'L'],
                'colors' => ['Crema', 'Verde oliva'],
                'stock' => 14,
                'is_featured' => false,
            ],
            [
                'name' => 'Jogger Street Move',
                'slug' => 'jogger-street-move',
                'category' => 'Pantalones',
                'description' => 'Jogger urbano con cintura elastica y caida relajada.',
                'price' => 119900,
                'cost_price' => 58000,
                'discount_percent' => 5,
                'image' => 'https://images.unsplash.com/photo-1506629905607-bb5f7dd4f34f?auto=format&fit=crop&w=900&q=80',
                'sizes' => ['S', 'M', 'L', 'XL'],
                'colors' => ['Negro', 'Gris oscuro'],
                'stock' => 16,
                'is_featured' => false,
            ],
            [
                'name' => 'Zapatillas Retro Pulse',
                'slug' => 'zapatillas-retro-pulse',
                'category' => 'Zapatillas',
                'description' => 'Silueta retro con materiales mixtos para un look autentico.',
                'price' => 279900,
                'cost_price' => 170000,
                'discount_percent' => 15,
                'image' => 'https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?auto=format&fit=crop&w=900&q=80',
                'sizes' => ['39', '40', '41', '42', '43'],
                'colors' => ['Azul', 'Blanco'],
                'stock' => 10,
                'is_featured' => true,
            ],
        ];

        foreach ($products as $product) {
            $category = Category::query()->where('name', $product['category'])->first();

            Product::query()->updateOrCreate(
                ['slug' => $product['slug']],
                [
                    ...$product,
                    'category_id' => $category?->id,
                ]
            );
        }
    }
}
