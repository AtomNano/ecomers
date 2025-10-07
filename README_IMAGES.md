# Panduan Gambar Produk untuk Website E-commerce

## Gambar yang Sudah Tersedia

Website Anda sekarang sudah memiliki gambar sample untuk 20 produk dengan kategori yang beragam:

### Kategori Sembako
- **Beras Premium 5kg** - Rp 45.000 (satuan), Rp 42.000 (4+), Rp 40.000 (lusin)
- **Minyak Goreng 1L** - Rp 18.000 (satuan), Rp 17.000 (4+), Rp 16.000 (lusin)
- **Gula Pasir 1kg** - Rp 12.000 (satuan), Rp 11.000 (4+), Rp 10.000 (lusin)

### Kategori Minuman
- **Teh Celup 25s** - Rp 8.000 (satuan), Rp 7.500 (4+), Rp 7.000 (lusin)
- **Kopi Instan 3in1** - Rp 1.500 (satuan), Rp 1.400 (4+), Rp 1.300 (lusin)
- **Susu UHT 1L** - Rp 12.000 (satuan), Rp 11.000 (4+), Rp 10.000 (lusin)

### Kategori Makanan Ringan
- **Keripik Kentang** - Rp 5.000 (satuan), Rp 4.500 (4+), Rp 4.000 (lusin)
- **Biskuit Coklat** - Rp 3.000 (satuan), Rp 2.800 (4+), Rp 2.500 (lusin)

### Kategori Bumbu Dapur
- **Garam Dapur 500g** - Rp 3.000 (satuan), Rp 2.800 (4+), Rp 2.500 (lusin)
- **Kecap Manis 500ml** - Rp 8.000 (satuan), Rp 7.500 (4+), Rp 7.000 (lusin)
- **Sambal ABC 100g** - Rp 4.000 (satuan), Rp 3.800 (4+), Rp 3.500 (lusin)

### Kategori Perawatan Diri
- **Shampoo 400ml** - Rp 15.000 (satuan), Rp 14.000 (4+), Rp 13.000 (lusin)
- **Sabun Mandi 90g** - Rp 5.000 (satuan), Rp 4.500 (4+), Rp 4.000 (lusin)
- **Pasta Gigi 100g** - Rp 8.000 (satuan), Rp 7.500 (4+), Rp 7.000 (lusin)

### Kategori Pembersih Rumah
- **Deterjen 1kg** - Rp 12.000 (satuan), Rp 11.000 (4+), Rp 10.000 (lusin)
- **Sabun Cuci Piring 500ml** - Rp 6.000 (satuan), Rp 5.500 (4+), Rp 5.000 (lusin)

### Kategori Obat-obatan
- **Paracetamol 500mg** - Rp 2.000 (satuan), Rp 1.800 (4+), Rp 1.500 (lusin)

### Kategori Produk Segar
- **Telur Ayam 1kg** - Rp 25.000 (satuan), Rp 23.000 (4+), Rp 22.000 (lusin)

### Kategori Perlengkapan Bayi
- **Popok Bayi M** - Rp 35.000 (satuan), Rp 32.000 (4+), Rp 30.000 (lusin)

## Lokasi File Gambar

Semua gambar tersimpan di: `public/storage/products/`

## Cara Menambahkan Gambar Baru

1. **Upload melalui Admin Panel**: Gunakan form tambah/edit produk di admin panel
2. **Upload Manual**: Copy gambar ke folder `public/storage/products/`
3. **Regenerate dengan Script**: Jalankan `php scripts/download_sample_images.php`

## Spesifikasi Gambar yang Disarankan

- **Format**: JPG, PNG
- **Ukuran**: 600x600 pixels (1:1 ratio)
- **Ukuran File**: Maksimal 2MB
- **Kualitas**: High resolution untuk tampilan yang baik

## Fitur Harga Bertingkat

Website mendukung sistem harga bertingkat:
- **Harga Satuan**: Untuk pembelian 1-3 item
- **Harga 4+**: Untuk pembelian 4-11 item
- **Harga Lusin**: Untuk pembelian 12+ item

## Produk Unggulan

Beberapa produk ditandai sebagai "Featured" (unggulan):
- Beras Premium 5kg
- Minyak Goreng 1L
- Kopi Instan 3in1
- Telur Ayam 1kg

## Catatan Penting

- Gambar diambil dari Unsplash (gratis untuk komersial)
- Semua harga dalam Rupiah (IDR)
- Stok produk diatur secara random untuk demo
- Website sudah siap untuk ditampilkan dengan data sample yang realistis
