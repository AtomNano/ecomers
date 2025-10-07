<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        for ($i = 1; $i <= 10; $i++) {
            $productName = 'Produk ' . $i;
            Product::create([
                'name' => $productName,
                'slug' => Str::slug($productName),
                'description' => 'Deskripsi untuk produk ' . $i,
                'price_per_piece' => rand(10000, 100000),
                'price_per_four' => rand(8000, 90000),
                'price_per_dozen' => rand(7000, 80000),
                'stock' => rand(10, 100),
                'is_featured' => rand(0, 1),
                'category_id' => $categories->random()->id,
            ]);
        }
    }
}
