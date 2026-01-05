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
        StoreSetting::truncate();
        StoreSetting::create([
            'store_name' => 'Grosir Berkat Ibu',
            'phone' => '0812-3456-7890',
            'address' => 'Jl. Pasar Grosir No. 123, Jakarta Pusat',
            'city' => 'Jakarta Pusat',
            'province' => 'DKI Jakarta',
            'district' => 'Tanah Abang',
            'maps_url' => 'https://maps.google.com',
            'bank_name' => 'BCA',
            'bank_account_number' => '8888-9999-0000',
            'bank_account_holder' => 'CV Grosir Berkat Ibu',
        ]);
    }
}
