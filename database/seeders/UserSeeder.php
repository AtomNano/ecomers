<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Owner
        User::firstOrCreate(
            ['email' => 'owner@example.com'],
            [
                'name' => 'Owner User',
                'password' => Hash::make('password'),
                'role' => User::ROLE_OWNER,
                'address' => '123 Owner St',
                'phone_number' => '1234567890',
                'province' => 'Province',
                'city' => 'City',
                'district' => 'District',
            ]
        );

        // Create Admin
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => User::ROLE_ADMIN,
                'address' => '456 Admin St',
                'phone_number' => '0987654321',
                'province' => 'Province',
                'city' => 'City',
                'district' => 'District',
            ]
        );

        // Create Customers
        User::factory()->count(8)->create();
    }
}