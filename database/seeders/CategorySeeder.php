<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Sembako',
            'Minuman',
            'Makanan Ringan',
            'Bumbu Dapur',
            'Perawatan Diri',
            'Pembersih Rumah',
            'Obat-obatan',
            'Produk Segar',
            'Perlengkapan Bayi',
            'Lain-lain',
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'slug' => Str::slug($category),
            ]);
        }
    }
}
