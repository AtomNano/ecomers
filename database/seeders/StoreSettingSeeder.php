<?php

namespace Database\Seeders;

use App\Models\StoreSetting;
use Illuminate\Database\Seeder;

class StoreSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StoreSetting::create([
            'store_name' => 'Grosir Berkat Ibu',
            'phone' => '(021) 1234-5678',
            'address' => 'Jl. Pasar Grosir No. 123, Jakarta Pusat 12190',
            'city' => 'Jakarta',
            'province' => 'Jakarta',
            'district' => 'Jakarta Pusat',
            'maps_url' => null,
        ]);
    }
}
