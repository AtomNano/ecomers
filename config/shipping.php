<?php

/**
 * SHIPPING CONFIGURATION
 * 
 * ⚠️ IMPORTANT: Ini adalah file konfigurasi yang sering berubah
 * Jangan hardcode shipping cost di dalam controller!
 * Update nilai-nilai di sini jika ada perubahan tarif.
 */

return [
    
    // Opsi metode pengiriman yang tersedia
    'methods' => [
        'gosend' => [
            'name' => 'Go Send (Same Day)',
            'cost' => 15000, // Rp 15.000
            'description' => 'Pengiriman hari yang sama',
            'enabled' => true,
        ],
        'jne' => [
            'name' => 'JNE Regular',
            'cost' => 20000, // Rp 20.000 (placeholder)
            'description' => 'Pengiriman 1-3 hari',
            'enabled' => false, // Belum diimplementasi
        ],
        'pickup' => [
            'name' => 'Pick Up di Toko',
            'cost' => 0,
            'description' => 'Ambil sendiri di lokasi toko',
            'enabled' => true,
        ],
    ],
    
    // Lokasi toko untuk pickup
    'pickup_location' => [
        'name' => 'Grosir Berkat Ibu',
        'address' => 'Jl. Raya No. 123, Kota, Provinsi',
        'phone' => '+6281234567890',
        'hours' => '08:00 - 17:00 (Senin-Jumat)',
    ],

    // Cost calculation rules (untuk future: dynamic pricing)
    'weight_based' => false, // Belum diimplementasi
    'location_based' => false, // Belum diimplementasi
    
];
