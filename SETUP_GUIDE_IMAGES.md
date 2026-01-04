# Setup Guide: Product Images & Database Seeding

## Untuk Developer Baru

Panduan ini menjelaskan cara setup project **Grosir Berkat Ibu** di PC baru dengan lengkap, termasuk gambar produk dan database.

### Langkah-langkah Setup

#### 1. Clone Repository
```bash
git clone <repository-url>
cd Grosir_Berkat_Ibu
```

#### 2. Install Dependencies
```bash
composer install
npm install
```

#### 3. Setup Environment
```bash
# Copy file .env.example ke .env
copy .env.example .env

# Generate application key
php artisan key:generate
```

#### 4. Konfigurasi Database
Edit file `.env` dan sesuaikan konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=grosir_berkat_ibu
DB_USERNAME=root
DB_PASSWORD=
```

#### 5. Run Migration & Seeding
```bash
php artisan migrate:fresh --seed
```

**Perintah ini akan:**
- ✅ Membuat semua tabel database
- ✅ Mengisi data kategori produk
- ✅ **Otomatis copy 70 gambar produk** dari `gambar_produk/` ke `public/storage/products/`
- ✅ Mengisi data produk dengan referensi gambar yang benar
- ✅ Membuat user default (admin & customer)
- ✅ Mengisi pengaturan toko
- ✅ Generate dummy data transaksi

#### 6. Run Development Server
```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

---

## Struktur Gambar Produk

### Lokasi Gambar
- **Source (backup)**: `gambar_produk/` - Folder asli berisi 70 gambar produk
- **Public (aktif)**: `public/storage/products/` - Folder yang digunakan aplikasi dan ter-commit ke Git

### Path di Database
Semua produk menggunakan path: `storage/products/namafile.png`

Contoh:
```php
'image' => 'storage/products/gooddaycapuchino.png'
```

### Akses via URL
Gambar dapat diakses melalui:
```
http://localhost:8000/storage/products/gooddaycapuchino.png
```

---

## Seeder yang Tersedia

### 1. CategorySeeder
Mengisi kategori produk (Makanan & Minuman, Bumbu & Saus, dll.)

### 2. ImageSeeder ⭐ (Baru)
**Otomatis copy gambar produk** dari `gambar_produk/` ke `public/storage/products/`
- Membuat folder jika belum ada
- Copy 70 file gambar
- Memberikan feedback jika ada yang gagal

### 3. ProductSeeder
Mengisi 70 produk dengan detail lengkap:
- Nama, deskripsi, harga
- Stok, kategori
- **Referensi gambar** di `storage/products/`

### 4. UserSeeder
Membuat user default untuk testing

### 5. StoreSettingSeeder
Mengisi pengaturan toko

### 6. DummyDataSeeder
Generate data transaksi dummy untuk testing

---

## Troubleshooting

### Gambar tidak muncul?
1. Pastikan seeding sudah dijalankan: `php artisan migrate:fresh --seed`
2. Cek folder `public/storage/products/` sudah berisi gambar
3. Pastikan permission folder sudah benar (755)

### Seeding gagal?
1. Pastikan database sudah dibuat
2. Cek konfigurasi `.env` sudah benar
3. Jalankan `composer dump-autoload` lalu coba lagi

### Gambar tidak ter-commit ke Git?
File `.gitignore` sudah dikonfigurasi untuk **mengecualikan** folder `public/storage/products/` dari ignore, sehingga gambar akan ter-track di Git.

---

## Catatan Penting

⚠️ **Jangan hapus folder `gambar_produk/`** - Folder ini adalah backup asli gambar produk

✅ **Folder `public/storage/products/` sudah ter-commit** ke Git, jadi developer lain akan langsung mendapat gambar saat clone

✅ **ImageSeeder akan otomatis copy ulang** gambar saat seeding, jadi aman untuk development

---

## Kontak

Jika ada masalah, hubungi tim development atau buat issue di repository.
