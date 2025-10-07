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

        // Data produk dengan gambar dan harga yang realistis
        $products = [
            [
                'name' => 'Beras Premium 5kg',
                'description' => 'Beras premium berkualitas tinggi, cocok untuk konsumsi sehari-hari keluarga.',
                'price_per_piece' => 45000,
                'price_per_four' => 42000,
                'price_per_dozen' => 40000,
                'stock' => 50,
                'is_featured' => true,
                'image' => 'beras-premium-5kg.jpg',
                'category' => 'Sembako'
            ],
            [
                'name' => 'Minyak Goreng 1L',
                'description' => 'Minyak goreng berkualitas tinggi, bebas kolesterol.',
                'price_per_piece' => 18000,
                'price_per_four' => 17000,
                'price_per_dozen' => 16000,
                'stock' => 100,
                'is_featured' => true,
                'image' => 'minyak-goreng-1l.jpg',
                'category' => 'Sembako'
            ],
            [
                'name' => 'Gula Pasir 1kg',
                'description' => 'Gula pasir putih berkualitas premium.',
                'price_per_piece' => 12000,
                'price_per_four' => 11000,
                'price_per_dozen' => 10000,
                'stock' => 75,
                'is_featured' => false,
                'image' => 'gula-pasir-1kg.jpg',
                'category' => 'Sembako'
            ],
            [
                'name' => 'Teh Celup 25s',
                'description' => 'Teh celup berkualitas dengan aroma yang harum.',
                'price_per_piece' => 8000,
                'price_per_four' => 7500,
                'price_per_dozen' => 7000,
                'stock' => 200,
                'is_featured' => false,
                'image' => 'teh-celup-25s.jpg',
                'category' => 'Minuman'
            ],
            [
                'name' => 'Kopi Instan 3in1',
                'description' => 'Kopi instan dengan gula dan krimer, praktis dan nikmat.',
                'price_per_piece' => 1500,
                'price_per_four' => 1400,
                'price_per_dozen' => 1300,
                'stock' => 500,
                'is_featured' => true,
                'image' => 'kopi-instan-3in1.jpg',
                'category' => 'Minuman'
            ],
            [
                'name' => 'Susu UHT 1L',
                'description' => 'Susu UHT segar dengan kandungan nutrisi lengkap.',
                'price_per_piece' => 12000,
                'price_per_four' => 11000,
                'price_per_dozen' => 10000,
                'stock' => 80,
                'is_featured' => false,
                'image' => 'susu-uht-1l.jpg',
                'category' => 'Minuman'
            ],
            [
                'name' => 'Keripik Kentang',
                'description' => 'Keripik kentang renyah dengan berbagai rasa.',
                'price_per_piece' => 5000,
                'price_per_four' => 4500,
                'price_per_dozen' => 4000,
                'stock' => 150,
                'is_featured' => false,
                'image' => 'keripik-kentang.jpg',
                'category' => 'Makanan Ringan'
            ],
            [
                'name' => 'Biskuit Coklat',
                'description' => 'Biskuit dengan isian coklat yang lezat.',
                'price_per_piece' => 3000,
                'price_per_four' => 2800,
                'price_per_dozen' => 2500,
                'stock' => 300,
                'is_featured' => false,
                'image' => 'biskuit-coklat.jpg',
                'category' => 'Makanan Ringan'
            ],
            [
                'name' => 'Garam Dapur 500g',
                'description' => 'Garam dapur halus untuk kebutuhan memasak.',
                'price_per_piece' => 3000,
                'price_per_four' => 2800,
                'price_per_dozen' => 2500,
                'stock' => 200,
                'is_featured' => false,
                'image' => 'garam-dapur-500g.jpg',
                'category' => 'Bumbu Dapur'
            ],
            [
                'name' => 'Kecap Manis 500ml',
                'description' => 'Kecap manis berkualitas untuk masakan Indonesia.',
                'price_per_piece' => 8000,
                'price_per_four' => 7500,
                'price_per_dozen' => 7000,
                'stock' => 120,
                'is_featured' => false,
                'image' => 'kecap-manis-500ml.jpg',
                'category' => 'Bumbu Dapur'
            ],
            [
                'name' => 'Sambal ABC 100g',
                'description' => 'Sambal pedas dengan rasa yang autentik.',
                'price_per_piece' => 4000,
                'price_per_four' => 3800,
                'price_per_dozen' => 3500,
                'stock' => 180,
                'is_featured' => false,
                'image' => 'sambal-abc-100g.jpg',
                'category' => 'Bumbu Dapur'
            ],
            [
                'name' => 'Shampoo 400ml',
                'description' => 'Shampoo untuk perawatan rambut sehari-hari.',
                'price_per_piece' => 15000,
                'price_per_four' => 14000,
                'price_per_dozen' => 13000,
                'stock' => 60,
                'is_featured' => false,
                'image' => 'shampoo-400ml.jpg',
                'category' => 'Perawatan Diri'
            ],
            [
                'name' => 'Sabun Mandi 90g',
                'description' => 'Sabun mandi dengan formula lembut untuk kulit.',
                'price_per_piece' => 5000,
                'price_per_four' => 4500,
                'price_per_dozen' => 4000,
                'stock' => 250,
                'is_featured' => false,
                'image' => 'sabun-mandi-90g.jpg',
                'category' => 'Perawatan Diri'
            ],
            [
                'name' => 'Pasta Gigi 100g',
                'description' => 'Pasta gigi dengan fluoride untuk perlindungan gigi.',
                'price_per_piece' => 8000,
                'price_per_four' => 7500,
                'price_per_dozen' => 7000,
                'stock' => 100,
                'is_featured' => false,
                'image' => 'pasta-gigi-100g.jpg',
                'category' => 'Perawatan Diri'
            ],
            [
                'name' => 'Deterjen 1kg',
                'description' => 'Deterjen bubuk untuk mencuci pakaian.',
                'price_per_piece' => 12000,
                'price_per_four' => 11000,
                'price_per_dozen' => 10000,
                'stock' => 80,
                'is_featured' => false,
                'image' => 'deterjen-1kg.jpg',
                'category' => 'Pembersih Rumah'
            ],
            [
                'name' => 'Sabun Cuci Piring 500ml',
                'description' => 'Sabun cuci piring dengan formula anti bakteri.',
                'price_per_piece' => 6000,
                'price_per_four' => 5500,
                'price_per_dozen' => 5000,
                'stock' => 150,
                'is_featured' => false,
                'image' => 'sabun-cuci-piring-500ml.jpg',
                'category' => 'Pembersih Rumah'
            ],
            [
                'name' => 'Paracetamol 500mg',
                'description' => 'Obat penurun demam dan pereda nyeri.',
                'price_per_piece' => 2000,
                'price_per_four' => 1800,
                'price_per_dozen' => 1500,
                'stock' => 500,
                'is_featured' => false,
                'image' => 'paracetamol-500mg.jpg',
                'category' => 'Obat-obatan'
            ],
            [
                'name' => 'Telur Ayam 1kg',
                'description' => 'Telur ayam segar berkualitas tinggi.',
                'price_per_piece' => 25000,
                'price_per_four' => 23000,
                'price_per_dozen' => 22000,
                'stock' => 40,
                'is_featured' => true,
                'image' => 'telur-ayam-1kg.jpg',
                'category' => 'Produk Segar'
            ],
            [
                'name' => 'Popok Bayi M',
                'description' => 'Popok bayi ukuran M dengan daya serap tinggi.',
                'price_per_piece' => 35000,
                'price_per_four' => 32000,
                'price_per_dozen' => 30000,
                'stock' => 30,
                'is_featured' => false,
                'image' => 'popok-bayi-m.jpg',
                'category' => 'Perlengkapan Bayi'
            ]
        ];

        foreach ($products as $productData) {
            $category = $categories->where('name', $productData['category'])->first();
            
            if ($category) {
                Product::create([
                    'name' => $productData['name'],
                    'slug' => Str::slug($productData['name']),
                    'description' => $productData['description'],
                    'image' => $productData['image'],
                    'price_per_piece' => $productData['price_per_piece'],
                    'price_per_four' => $productData['price_per_four'],
                    'price_per_dozen' => $productData['price_per_dozen'],
                    'stock' => $productData['stock'],
                    'is_featured' => $productData['is_featured'],
                    'sales_count' => rand(0, 100),
                    'category_id' => $category->id,
                ]);
            }
        }
    }
}