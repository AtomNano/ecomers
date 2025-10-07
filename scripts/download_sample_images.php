<?php

/**
 * Script untuk download gambar sample produk dari API gratis
 * Jalankan dengan: php scripts/download_sample_images.php
 */

// URL gambar sample dari berbagai sumber gratis
$sampleImages = [
    'beras-premium-5kg.jpg' => 'https://images.unsplash.com/photo-1586201375761-83865001e31c?w=600&h=600&fit=crop',
    'minyak-goreng-1l.jpg' => 'https://images.unsplash.com/photo-1474979266404-7eaacbcd87c5?w=600&h=600&fit=crop',
    'gula-pasir-1kg.jpg' => 'https://images.unsplash.com/photo-1558961363-fa8fdf82db35?w=600&h=600&fit=crop',
    'teh-celup-25s.jpg' => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=600&h=600&fit=crop',
    'kopi-instan-3in1.jpg' => 'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?w=600&h=600&fit=crop',
    'susu-uht-1l.jpg' => 'https://images.unsplash.com/photo-1550583724-b2692b85b150?w=600&h=600&fit=crop',
    'keripik-kentang.jpg' => 'https://images.unsplash.com/photo-1566478989037-eec170784d0b?w=600&h=600&fit=crop',
    'biskuit-coklat.jpg' => 'https://images.unsplash.com/photo-1558961363-fa8fdf82db35?w=600&h=600&fit=crop',
    'garam-dapur-500g.jpg' => 'https://images.unsplash.com/photo-1596040033229-a9821ebd058d?w=600&h=600&fit=crop',
    'kecap-manis-500ml.jpg' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=600&h=600&fit=crop',
    'sambal-abc-100g.jpg' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=600&h=600&fit=crop',
    'shampoo-400ml.jpg' => 'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=600&h=600&fit=crop',
    'sabun-mandi-90g.jpg' => 'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=600&h=600&fit=crop',
    'pasta-gigi-100g.jpg' => 'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=600&h=600&fit=crop',
    'deterjen-1kg.jpg' => 'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=600&h=600&fit=crop',
    'sabun-cuci-piring-500ml.jpg' => 'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=600&h=600&fit=crop',
    'paracetamol-500mg.jpg' => 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=600&h=600&fit=crop',
    'telur-ayam-1kg.jpg' => 'https://images.unsplash.com/photo-1518569656558-1f25e69d93d3?w=600&h=600&fit=crop',
    'popok-bayi-m.jpg' => 'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=600&h=600&fit=crop'
];

// Pastikan direktori storage/products ada
$storageDir = __DIR__ . '/../public/storage/products';
if (!is_dir($storageDir)) {
    mkdir($storageDir, 0755, true);
}

echo "Memulai download gambar sample...\n";

foreach ($sampleImages as $filename => $url) {
    $filepath = $storageDir . '/' . $filename;
    
    // Skip jika file sudah ada
    if (file_exists($filepath)) {
        echo "File $filename sudah ada, skip...\n";
        continue;
    }
    
    echo "Downloading $filename...\n";
    
    // Download gambar
    $imageData = file_get_contents($url);
    
    if ($imageData !== false) {
        file_put_contents($filepath, $imageData);
        echo "✓ Berhasil download $filename\n";
    } else {
        echo "✗ Gagal download $filename\n";
    }
    
    // Delay untuk menghindari rate limiting
    sleep(1);
}

echo "\nDownload selesai!\n";
echo "Gambar tersimpan di: $storageDir\n";
