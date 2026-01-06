<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Sayuran Segar', 'description' => 'Sayuran hijau dan segar berkualitas tinggi'],
            ['name' => 'Buah-Buahan', 'description' => 'Buah-buahan tropis dan impor'],
            ['name' => 'Bahan Bumbu', 'description' => 'Bumbu dapur lengkap'],
            ['name' => 'Beras & Gandum', 'description' => 'Beras, gandum, dan produk serelia'],
            ['name' => 'Minyak & Lemak', 'description' => 'Minyak goreng dan produk lemak'],
            ['name' => 'Makanan Kaleng', 'description' => 'Makanan kaleng dan pengawet'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}
