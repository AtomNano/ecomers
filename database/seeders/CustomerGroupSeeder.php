<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CustomerGroup;
use Illuminate\Support\Str;

class CustomerGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = [
            [
                'name' => 'Umum',
                'description' => 'Pelanggan umum dengan harga standar',
                'is_active' => true
            ],
            [
                'name' => 'Reseller',
                'description' => 'Pelanggan reseller dengan harga khusus',
                'is_active' => true
            ],
            [
                'name' => 'VIP',
                'description' => 'Pelanggan VIP dengan harga terbaik',
                'is_active' => true
            ]
        ];

        foreach ($groups as $group) {
            CustomerGroup::create([
                'name' => $group['name'],
                'slug' => Str::slug($group['name']),
                'description' => $group['description'],
                'is_active' => $group['is_active']
            ]);
        }
    }
}
