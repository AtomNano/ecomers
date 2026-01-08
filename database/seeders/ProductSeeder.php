<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Optional: Truncate tables if in local to avoid duplicates
        if (app()->isLocal()) {
            Schema::disableForeignKeyConstraints();
            DB::table('products')->truncate();
            // Don't truncate categories if they are seeded separately, but here we might want to ensure they exist for the products
            Schema::enableForeignKeyConstraints();
        }

        // 1. Define Categories mapping
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
            $cat = Category::firstOrCreate(
                ['name' => $name],
                ['description' => $data['description'], 'slug' => $data['slug']]
            );
            $catMap[$name] = $cat;
        }

        // 2. Define Product Data Mapping (Image partial name -> Data)
        $productDefinitions = [
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
            'minyakurut' => ['Minyak Urut GPU', 'Kesehatan', 18000, 200000],

            // Mie & Beras
            'miechina' => ['Mie Telur Cap Burung', 'Beras, Mie & Pasta', 12000, 130000],
            'miesari' => ['Mie Sari', 'Beras, Mie & Pasta', 3500, 100000],
            'miesedap' => ['Mie Sedaap Goreng', 'Beras, Mie & Pasta', 3500, 102000],
            'sedapcup' => ['Mie Sedaap Cup Basics', 'Beras, Mie & Pasta', 5500, 125000],
            'sedappanasspiccy' => ['Mie Sedaap Cup Spicy', 'Beras, Mie & Pasta', 6000, 135000],
            'lasagna' => ['La Fonte Lasagna', 'Beras, Mie & Pasta', 28000, 320000],
            'ovalincekecil' => ['Oval Indomie Kecil', 'Beras, Mie & Pasta', 2000, 20000],
            'ovaline' => ['Oval Indomie Original', 'Beras, Mie & Pasta', 2500, 25000],

            // Minuman & Susu
            'kapanapi' => ['Kopi Kapal Api Spesial', 'Minuman', 15000, 170000],
            'kapalapipack' => ['Kopi Kapal Api Besar', 'Minuman', 55000, 600000],
            'goodday' => ['Kopi Good Day Cappuccino', 'Minuman', 18000, 200000],
            'neocopi' => ['Neo Coffee Moccachino', 'Minuman', 12000, 135000],
            'excelso' => ['Kopi Excelso Robusta', 'Minuman', 45000, 500000],
            'sariwangi' => ['Teh Sariwangi', 'Minuman', 8500, 95000],
            'milobubuk' => ['Milo Bubuk Cokelat', 'Minuman', 25000, 250000],
            'waltercholact' => ['Hot Chocolate Walter', 'Minuman', 65000, 700000],
            'susukentalkaleng' => ['Susu Kental Manis Kaleng', 'Minuman', 15000, 150000],
            'susukentalbingkisan' => ['Susu Kental Manis Bingkisan', 'Minuman', 12000, 120000],
            'pocary' => ['Pocari Sweat 500ml', 'Minuman', 8000, 190000],
            'mamajeruk' => ['Mama Jeruk Fresh', 'Minuman', 5000, 50000],

            // Snack
            'silverqueen' => ['Coklat Silverqueen', 'Snack & Camilan', 18000, 200000],
            'chacha' => ['Coklat Cha-Cha', 'Snack & Camilan', 10000, 110000],
            'biskuit' => ['Biskuit Kelapa', 'Snack & Camilan', 9500, 105000],
            'classicwaffer' => ['Classic Wafer Coklat', 'Snack & Camilan', 12000, 135000],
            'twister' => ['Twister Chocolate Stick', 'Snack & Camilan', 15000, 170000],

            // Perawatan Diri
            'bioreUV' => ['Biore UV Sunscreen', 'Perawatan Diri', 45000, 500000],
            'menbiore' => ['Men\'s Biore Facial Wash', 'Perawatan Diri', 32000, 360000],
            'citra' => ['Citra Hand & Body Lotion', 'Perawatan Diri', 22000, 250000],
            'dove' => ['Dove Shampoo', 'Perawatan Diri', 35000, 400000],
            'clear' => ['Clear Shampoo Anti-Dandruff', 'Perawatan Diri', 32000, 370000],
            'herbal' => ['Herbal Essences Shampoo', 'Perawatan Diri', 55000, 600000],
            'ponds' => ['Ponds Facial Foam Deep Clean', 'Perawatan Diri', 28000, 320000],
            'ponst1' => ['Ponds Men Day Cream', 'Perawatan Diri', 42000, 420000],
            'poundmen' => ['Pound Men Pack', 'Perawatan Diri', 72000, 720000],
            'poundtwind' => ['Ponds Men Twin Pack', 'Perawatan Diri', 75000, 750000],
            'niveamen2' => ['Nivea Men Cream', 'Perawatan Diri', 48000, 480000],
            'niveamenpack2' => ['Nivea Men Grooming Pack', 'Perawatan Diri', 55000, 550000],
            'pepsodent' => ['Pepsodent Pencegah Gigi Berlubang', 'Perawatan Diri', 12000, 135000],
            'ciptadent' => ['Ciptadent Fresh Mint', 'Perawatan Diri', 8000, 90000],
            'sikat' => ['Sikat Gigi Formula', 'Perawatan Diri', 15000, 170000],
            'listreine' => ['Listerine Mouthwash', 'Perawatan Diri', 25000, 280000],

            // Perlengkapan Rumah
            'mamacucipiring' => ['Mama Lemon Pencuci Piring', 'Perlengkapan Rumah', 15000, 160000],
            'sunlight' => ['Sunlight Jeruk Nipis', 'Perlengkapan Rumah', 16000, 170000],
            'sunlich' => ['Sunlight Habbatussauda', 'Perlengkapan Rumah', 16000, 170000],
            'sosoft' => ['SoSoft Detergen Cair', 'Perlengkapan Rumah', 18000, 200000],
            'detergen' => ['Detergen Cair Attack', 'Perlengkapan Rumah', 25000, 280000],
            'vape' => ['Vape Obat Nyamuk Semprot', 'Perlengkapan Rumah', 35000, 400000],
            'hit' => ['Hit Obat Nyamuk Spray', 'Perlengkapan Rumah', 32000, 360000],
            'tessa' => ['Tisu Wajah Tessa', 'Perlengkapan Rumah', 15000, 160000],
            'tessatisu' => ['Tisu Kotak Tessa', 'Perlengkapan Rumah', 18000, 180000],

            // Kesehatan
            'salonpas' => ['Salonpas Koyo Pereda Nyeri', 'Kesehatan', 12000, 130000],
            'tolakangin' => ['Tolak Angin Cair (Box)', 'Kesehatan', 45000, 500000],
            'obat' => ['Obat Flu & Batuk', 'Kesehatan', 15000, 0],
            'vector' => ['Minyak Angin Vector', 'Kesehatan', 25000, 0],
            'totolekaldujamur' => ['Total Obat Jamur Kaki', 'Kesehatan', 35000, 350000],

            // Makanan Kaleng / Lainnya
            'kimchi' => ['Kimchi Korea Asli', 'Makanan Kaleng', 55000, 600000],
        ];

        // 3. Scan Directory and Create Products
        $storagePath = storage_path('app/public/products');

        if (!is_dir($storagePath)) {
            $this->command->error("Directory not found: $storagePath");
            return;
        }

        $files = scandir($storagePath);
        $seededProducts = 0;

        foreach ($files as $file) {
            if ($file === '.' || $file === '..')
                continue;

            // Find match
            $matchedKey = null;
            foreach ($productDefinitions as $key => $data) {
                if (stripos($file, $key) !== false) {
                    $matchedKey = $key;
                    break;
                }
            }

            if ($matchedKey) {
                $data = $productDefinitions[$matchedKey];
                $categoryName = $data[1];

                // Ensure category exists (safe-guard)
                if (!isset($catMap[$categoryName])) {
                    $catMap[$categoryName] = Category::firstOrCreate(['name' => $categoryName]);
                }

                $categoryId = $catMap[$categoryName]->id;

                Product::updateOrCreate([
                    'name' => $data[0],
                ], [
                    'category_id' => $categoryId,
                    'name' => $data[0],
                    'description' => 'Produk berkualitas ' . $data[0] . '. Tersedia dalam harga satuan dan grosir.',
                    'price_unit' => $data[2],
                    'price_dozen' => $data[3] > 0 ? $data[3] : $data[2] * 11,
                    'price_bulk_4' => $data[2] - ($data[2] * 0.05),
                    'stock' => rand(20, 100),
                    'min_stock' => 5,
                    'unit' => 'Pcs',
                    'box_item_count' => 12, // Default
                    'image' => 'products/' . $file, // Save relative path for storage link
                ]);
                $seededProducts++;
            }
        }

        // 4. Cleanup Empty Categories (As requested: "jgan buat klo ga ada product")
        foreach ($catMap as $cat) {
            if ($cat->products()->count() == 0) {
                $cat->delete();
            }
        }

        $this->command->info("Seeded $seededProducts products from images.");
    }
}
