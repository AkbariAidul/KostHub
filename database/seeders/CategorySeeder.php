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
                'name' => 'Kos Putra',
                'slug' => 'kos-putra',
                'image' => 'categories/putra.jpg',
            ],
            [
                'name' => 'Kos Putri',
                'slug' => 'kos-putri',
                'image' => 'categories/putri.jpg',
            ],
            [
                'name' => 'Kos Pasutri/Campur',
                'slug' => 'kos-campur',
                'image' => 'categories/campur.jpg',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}