<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Rosas',
                'slug' => 'rosas',
                'description' => 'Rosas frescas e perfumadas nas mais variadas cores e estilos.',
                'image' => 'https://images.unsplash.com/photo-1518709268805-4e9042af9f23?w=400',
                'active' => true,
                'order' => 1,
            ],
            [
                'name' => 'Buquês',
                'slug' => 'buques',
                'description' => 'Buquês especialmente montados para todas as ocasiões.',
                'image' => 'https://images.unsplash.com/photo-1490750967868-88df5691cc0c?w=400',
                'active' => true,
                'order' => 2,
            ],
            [
                'name' => 'Arranjos',
                'slug' => 'arranjos',
                'description' => 'Arranjos florais sofisticados para decoração e presentes.',
                'image' => 'https://images.unsplash.com/photo-1567696153798-9111f9cd3d0d?w=400',
                'active' => true,
                'order' => 3,
            ],
            [
                'name' => 'Plantas',
                'slug' => 'plantas',
                'description' => 'Plantas ornamentais e suculentas para seu lar.',
                'image' => 'https://images.unsplash.com/photo-1501004318641-b39e6451bec6?w=400',
                'active' => true,
                'order' => 4,
            ],
            [
                'name' => 'Cestas',
                'slug' => 'cestas',
                'description' => 'Cestas com flores e presentes especiais.',
                'image' => 'https://images.unsplash.com/photo-1563241527-3004b7be0ffd?w=400',
                'active' => true,
                'order' => 5,
            ],
            [
                'name' => 'Flores Tropicais',
                'slug' => 'flores-tropicais',
                'description' => 'Flores tropicais exóticas e vibrantes.',
                'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400',
                'active' => true,
                'order' => 6,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
