<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            // Admin
            [
                'name' => 'Admin Toko',
                'email' => 'admin@grosir.com',
                'phone' => '081234567890',
                'address' => 'Jl. Admin No. 1, Jakarta',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ],
            // Owner
            [
                'name' => 'Owner Toko',
                'email' => 'owner@grosir.com',
                'phone' => '081298765432',
                'address' => 'Jl. Owner No. 1, Jakarta',
                'password' => Hash::make('password123'),
                'role' => 'owner',
            ],
            // Customers
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'phone' => '085712345678',
                'address' => 'Jl. Merdeka No. 10, Jakarta',
                'password' => Hash::make('password123'),
                'role' => 'customer',
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti@example.com',
                'phone' => '085812345678',
                'address' => 'Jl. Gatot Subroto No. 20, Jakarta',
                'password' => Hash::make('password123'),
                'role' => 'customer',
            ],
            [
                'name' => 'Ahmad Wijaya',
                'email' => 'ahmad@example.com',
                'phone' => '085912345678',
                'address' => 'Jl. Sudirman No. 30, Jakarta',
                'password' => Hash::make('password123'),
                'role' => 'customer',
            ],
            [
                'name' => 'Rina Kusuma',
                'email' => 'rina@example.com',
                'phone' => '086012345678',
                'address' => 'Jl. Jend. S Parman No. 40, Jakarta',
                'password' => Hash::make('password123'),
                'role' => 'customer',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
