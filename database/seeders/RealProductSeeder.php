<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Schema;

class RealProductSeeder extends Seeder
{
    public function run()
    {
        // Run destructive reset ONLY in local environment
        $isLocal = app()->isLocal();
        if ($isLocal) {
            Schema::disableForeignKeyConstraints();
            DB::table('order_items')->truncate();
            DB::table('orders')->truncate();
            DB::table('products')->truncate();
            DB::table('categories')->truncate();
            DB::table('carts')->truncate();
            Schema::enableForeignKeyConstraints();
        }

        // 2. Create Categories
        $categories = [
            'Bahan Bumbu' => ['slug' => 'bahan-bumbu', 'description' => 'Bumbu dapur, kecap, saus, dan penyedap rasa'],
            'Minyak & Lemak' => ['slug' => 'minyak-lemak', 'description' => 'Minyak goreng, margarin, dan olahannya'],
            'Beras, Mie & Pasta' => ['slug' => 'beras-mie', 'description' => 'Beras, mie instan, pasta, dan gandum'],
            'Minuman' => ['slug' => 'minuman', 'description' => 'Kopi, teh, susu, dan minuman segar'],
            'Snack & Camilan' => ['slug' => 'snack', 'description' => 'Biskuit, wafer, coklat, dan kripik'],
            'Makanan Kaleng' => ['slug' => 'makanan-kaleng', 'description' => 'Makanan siap saji dalam kemasan'],
            'Perawatan Diri' => ['slug' => 'perawatan-diri', 'description' => 'Sabun, shampo, pasta gigi, dan skincare'],
            'Perlengkapan Rumah' => ['slug' => 'perlengkapan-rumah', 'description' => 'Detergen, pembersih lantai, pembasmi serangga'],
            'Kesehatan' => ['slug' => 'kesehatan', 'description' => 'Obat-obatan, vitamin, dan suplemen'],
        ];

        $catMap = [];
        foreach ($categories as $name => $data) {
            $cat = Category::updateOrCreate(
                ['name' => $name],
                ['description' => $data['description']]
            );
            $catMap[$name] = $cat;
        }

        // 3. Define Product Mapping (Filename -> Data)
        // Format: 'filename_fragment' => ['name', 'Category Name', price_unit, price_dozen]
        $products = [
            // Bumbu & Masak
            'bango' => ['Kecap Bango Manis', 'Bahan Bumbu', 25000, 280000],
            'kecapmanis' => ['Kecap Manis ABC', 'Bahan Bumbu', 22000, 250000],
            'kecapcina' => ['Kecap Asin Oriental', 'Bahan Bumbu', 35000, 400000],
            'kecapmurni' => ['Kecap Murni Cap Ikan', 'Bahan Bumbu', 18000, 200000],
            'roycoayam' => ['Royco Rasa Ayam (Sachet)', 'Bahan Bumbu', 5000, 55000],
            'roycojagung' => ['Royco Sup Krim Jagung', 'Bahan Bumbu', 8000, 90000],
            'totole' => ['Totole Kaldu Jamur', 'Bahan Bumbu', 35000, 400000],
            'mustard' => ['Mustard Sauce', 'Bahan Bumbu', 45000, 500000],
            'sambaabc' => ['Sambal ABC Pedas', 'Bahan Bumbu', 15000, 170000],
            
            // Minyak
            'minyakgoreng' => ['Minyak Goreng Sania', 'Minyak & Lemak', 32000, 370000],
            'minyakres' => ['Minyak Goreng Restoran 5L', 'Minyak & Lemak', 120000, 0],
            
            // Mie & Beras
            'miechina' => ['Mie Telur Cap Burung', 'Beras, Mie & Pasta', 12000, 130000],
            'miesari' => ['Mie Sari', 'Beras, Mie & Pasta', 3500, 100000],
            'miesedap' => ['Mie Sedaap Goreng', 'Beras, Mie & Pasta', 3500, 102000],
            'sedapcup' => ['Mie Sedaap Cup Basics', 'Beras, Mie & Pasta', 5500, 125000],
            'sedappanasspiccy' => ['Mie Sedaap Cup Spicy', 'Beras, Mie & Pasta', 6000, 135000],
            'lasagna' => ['La Fonte Lasagna', 'Beras, Mie & Pasta', 28000, 320000],
            
            // Minuman & Susu
            'kapanapi' => ['Kopi Kapal Api Spesial', 'Minuman', 15000, 170000],
            'kapalapipack' => ['Kopi Kapal Api Besar', 'Minuman', 55000, 600000],
            'goodday' => ['Kopi Good Day Cappuccino', 'Minuman', 18000, 200000],
            'neocopi' => ['Neo Coffee Moccachino', 'Minuman', 12000, 135000],
            'excelso' => ['Kopi Excelso Robusta', 'Minuman', 45000, 500000],
            'sariwangi' => ['Teh Sariwangi', 'Minuman', 8500, 95000],
            'milo' => ['Milo Activ-Go Bubuk', 'Minuman', 35000, 380000],
            'waltercholact' => ['Hot Chocolate Walter', 'Minuman', 65000, 700000],
            'susukental' => ['Susu Kental Manis Carnation', 'Minuman', 12500, 140000],
            'pocary' => ['Pocari Sweat 500ml', 'Minuman', 8000, 190000],
            
            // Snack
            'silverqueen' => ['Coklat Silverqueen', 'Snack & Camilan', 18000, 200000],
            'chacha' => ['Coklat Cha-Cha', 'Snack & Camilan', 10000, 110000],
            'biskuit' => ['Biskuit Kelapa', 'Snack & Camilan', 9500, 105000],
            'classicwaffer' => ['Classic Wafer Coklat', 'Snack & Camilan', 12000, 135000],
            'twister' => ['Twister Chocolate Stick', 'Snack & Camilan', 15000, 170000],
            
            // Perawatan Diri
            'biore' => ['Biore UV Sunscreen', 'Perawatan Diri', 45000, 500000],
            'menbiore' => ['Men\'s Biore Facial Wash', 'Perawatan Diri', 32000, 360000],
            'citra' => ['Citra Hand & Body Lotion', 'Perawatan Diri', 22000, 250000],
            'dove' => ['Dove Shampoo', 'Perawatan Diri', 35000, 400000],
            'clear' => ['Clear Shampoo Anti-Dandruff', 'Perawatan Diri', 32000, 370000],
            'herbal' => ['Herbal Essences Shampoo', 'Perawatan Diri', 55000, 600000],
            'ponds' => ['Ponds Facial Foam Deep Clean', 'Perawatan Diri', 28000, 320000],
            'nivea' => ['Nivea Men Deodorant', 'Perawatan Diri', 25000, 280000],
            'pepsodent' => ['Pepsodent Pencegah Gigi Berlubang', 'Perawatan Diri', 12000, 135000],
            'ciptadent' => ['Ciptadent Fresh Mint', 'Perawatan Diri', 8000, 90000],
            'sikat' => ['Sikat Gigi Formula', 'Perawatan Diri', 15000, 170000],
            'listreine' => ['Listerine Mouthwash', 'Perawatan Diri', 25000, 280000],
            'ovaline' => ['Ovaline Facial Mask', 'Perawatan Diri', 18000, 200000],
            
            // Perlengkapan Rumah
            'mama' => ['Mama Lemon Pencuci Piring', 'Perlengkapan Rumah', 15000, 160000],
            'sunlight' => ['Sunlight Jeruk Nipis', 'Perlengkapan Rumah', 16000, 170000],
            'sunlich' => ['Sunlight Habbatussauda', 'Perlengkapan Rumah', 16000, 170000],
            'sosoft' => ['SoSoft Detergen Cair', 'Perlengkapan Rumah', 18000, 200000],
            'detergen' => ['Detergen Cair Attack', 'Perlengkapan Rumah', 25000, 280000],
            'vape' => ['Vape Obat Nyamuk Semprot', 'Perlengkapan Rumah', 35000, 400000],
            'hit' => ['Hit Obat Nyamuk Spray', 'Perlengkapan Rumah', 32000, 360000],
            'tessa' => ['Tisu Wajah Tessa', 'Perlengkapan Rumah', 15000, 160000],

            // Kesehatan
            'minyakurut' => ['Minyak Urut GPU', 'Kesehatan', 18000, 200000],
            'salonpas' => ['Salonpas Koyo Pereda Nyeri', 'Kesehatan', 12000, 130000],
            'tolakangin' => ['Tolak Angin Cair (Box)', 'Kesehatan', 45000, 500000],
            'obat' => ['Obat Flu & Batuk', 'Kesehatan', 15000, 0],
            'vector' => ['Minyak Angin Vector', 'Kesehatan', 25000, 0],

            // Makanan Kaleng / Lainnya
            'kimchi' => ['Kimchi Korea Asli', 'Makanan Kaleng', 55000, 600000],
        ];

        // 4. Scan Directory and Create Products
        $files = scandir(storage_path('app/public/products'));
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') continue;
            
            // Find match
            $matchedKey = null;
            foreach ($products as $key => $data) {
                if (stripos($file, $key) !== false) {
                    $matchedKey = $key;
                    break;
                }
            }

            if ($matchedKey) {
                $data = $products[$matchedKey];
                $categoryName = $data[1];
                $categoryId = $catMap[$categoryName]->id;

                Product::updateOrCreate([
                    'name' => $data[0],
                    'category_id' => $categoryId,
                ], [
                    'category_id' => $categoryId,
                    'name' => $data[0],
                    'description' => 'Produk berkualitas ' . $data[0] . '. Tersedia dalam harga satuan dan grosir.',
                    'price_unit' => $data[2],
                    'price_dozen' => $data[3] > 0 ? $data[3] : $data[2] * 11, // Auto pricing if not set
                    'price_bulk_4' => $data[2] - ($data[2] * 0.05), // 5% discount
                    'stock' => rand(20, 100),
                    'image' => 'products/' . $file,
                ]);
            } else {
                // Generic fallback for unmatched files
                $cleanedName = ucwords(str_replace(['.png', '.jpg', '.jpeg', '_', '-'], ['','','',' ',' '], $file));
                
                // Guess Category
                $catId = $catMap['Perlengkapan Rumah']->id; // default
                if(stripos($file, 'food')!==false || stripos($file, 'makan')!==false) $catId = $catMap['Snack & Camilan']->id;

                Product::updateOrCreate([
                    'name' => $cleanedName,
                    'category_id' => $catId,
                ], [
                    'category_id' => $catId,
                    'name' => $cleanedName,
                    'description' => 'Produk ' . $cleanedName,
                    'price_unit' => rand(15000, 50000),
                    'price_dozen' => 0,
                    'price_bulk_4' => 0,
                    'stock' => rand(10, 50),
                    'image' => 'products/' . $file,
                ]);
            }
        }
    }
}
