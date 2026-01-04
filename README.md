# 🛒 Grosir Berkat Ibu - E-commerce Platform

Platform e-commerce berbasis Laravel untuk **Grosir Berkat Ibu** yang menyediakan sistem penjualan online terstruktur dengan support multi-role (Customer, Admin, Owner) dan sistem harga bertingkat untuk kebutuhan grosir.

---

## 📋 Daftar Isi

1. [Fitur Utama](#fitur-utama)
2. [Teknologi](#teknologi)
3. [Struktur Database](#struktur-database)
4. [Instalasi](#instalasi)
5. [Cara Penggunaan](#cara-penggunaan)
6. [API Endpoints](#api-endpoints)

---

## ✨ Fitur Utama

### Untuk Customer (Pembeli)
- ✅ **Home Page**: Barang terbaru, terlaris, kategori harian, lokasi grosir
- ✅ **Katalog Produk**: Lihat semua barang yang dijual
- ✅ **Sistem Harga Bertingkat**: Satuan, bulk (>4 pcs), grosir (lusin)
- ✅ **Keranjang Belanja**: Add/edit/remove items
- ✅ **Checkout**: Pengiriman (GoSend, ambil sendiri)
- ✅ **Pembayaran**: Transfer bank & QRIS
- ✅ **Upload Bukti Pembayaran**: Sistem verifikasi
- ✅ **Status Pesanan**: Tracking pembayaran & pengiriman
- ✅ **Tentang Website**: Info toko lengkap

### Untuk Admin
- ✅ **Dashboard**: Notifikasi pesanan masuk
- ✅ **Manajemen Barang**: CRUD dengan 3 jenis harga & stok real-time
- ✅ **Status Pembelian**: Verifikasi pembayaran & kontak WhatsApp
- ✅ **Laporan Keuangan**: Grafik bulanan & mingguan

### Untuk Owner
- ✅ **Dashboard Admin**: Semua fitur admin
- ✅ **Manajemen Data Pelanggan**: CRUD akun customer
- ✅ **Laporan & Monitoring**: Aktivitas & performa bisnis

---

## 🛠 Teknologi

| Teknologi | Versi |
|-----------|-------|
| **Framework** | Laravel 12 |
| **Database** | SQLite/MySQL |
| **Frontend** | Blade Templates |
| **Authentication** | Laravel Native |
| **PHP** | ^8.2 |

---

## 🗄️ Struktur Database

**Users** → Role (customer, admin, owner), Nama, Email, Alamat, Telepon  
**Products** → Nama, Deskripsi, 3 Jenis Harga (unit, bulk, dozen), Stok  
**Categories** → Kategori produk  
**Orders** → Pesanan dengan status (pending, payment_verified, shipped, completed)  
**OrderItems** → Detail item dalam order  
**Payments** → Pembayaran dengan bukti upload  
**Carts** → Keranjang belanja  
**StoreSetting** → Informasi toko  

---

## 🚀 Instalasi

### Prerequisites
- PHP >= 8.2
- Composer
- MySQL / SQLite

### Langkah Instalasi

```bash
# 1. Pindah ke direktori project
cd d:\github\semester5\Grosir_Berkat_Ibu

# 2. Install dependencies
composer install

# 3. Generate app key
php artisan key:generate

# 4. Setup database
php artisan migrate

# 5. Create admin account (optional)
php artisan tinker
# Di console:
App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'role' => 'admin',
    'phone' => '08123456789',
    'password' => bcrypt('password123'),
]);
exit

# 6. Run development server
php artisan serve
```

Akses di `http://localhost:8000`

---

## 📖 Cara Penggunaan

### Customer
1. Registrasi → Belanja → Checkout → Pembayaran → Upload Bukti → Tracking

### Admin
1. Login → Dashboard → Kelola Produk → Verifikasi Pembayaran → Laporan

### Owner
1. Login → Kelola Produk & Pesanan → Kelola Pelanggan → Laporan

---

## 🎯 Status Pengembangan

### ✅ Selesai
- Setup Laravel project
- Database & Models
- Routes lengkap
- Controllers (skeleton)
- Middleware role-based

### 🔄 Dikerjakan
- Controller logic implementation
- Blade views (HTML templates)
- Frontend styling
- File upload handling

---

**Version:** 1.0.0  
**Last Updated:** December 15, 2025


We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
