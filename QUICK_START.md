# 🚀 Quick Start Guide - Grosir Berkat Ibu

Panduan cepat untuk memulai development website e-commerce.

---

## ⚡ 5 Menit Setup

```bash
# 1. Pindah ke folder project
cd d:\github\semester5\Grosir_Berkat_Ibu

# 2. Install dependencies
composer install

# 3. Generate key & setup database
php artisan key:generate
php artisan migrate

# 4. Create admin account
php artisan tinker
App\Models\User::create(['name'=>'Admin','email'=>'admin@test.com','role'=>'admin','phone'=>'08123','password'=>bcrypt('admin123')])
exit

# 5. Run server
php artisan serve
```

**Akses:** http://localhost:8000/login

---

## 📁 Folder Structure

```
grosir-berkat-ibu/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/                    ← Authentication
│   │   │   ├── Customer/                ← Customer features
│   │   │   ├── Admin/                   ← Admin features
│   │   │   └── Owner/                   ← Owner features
│   │   └── Middleware/                  ← Role checking
│   │
│   └── Models/                          ← Database models
│       ├── User.php
│       ├── Product.php
│       ├── Order.php
│       └── ... (8 models total)
│
├── database/
│   ├── migrations/                      ← Database schemas
│   └── seeders/                         ← Sample data
│
├── routes/
│   └── web.php                          ← All route definitions
│
├── resources/
│   └── views/                           ← HTML templates (to be created)
│       ├── layouts/
│       ├── auth/
│       ├── customer/
│       ├── admin/
│       └── owner/
│
├── public/
│   ├── css/                             ← Stylesheets
│   ├── js/                              ← JavaScript
│   └── images/                          ← Static images
│
├── storage/
│   └── app/public/                      ← Uploaded files
│
├── config/                              ← Configuration files
├── bootstrap/                           ← Framework bootstrap
├── .env                                 ← Environment variables
├── README.md                            ← Project overview
├── IMPLEMENTATION_GUIDE.md              ← Code implementation details
├── SETUP_CHECKLIST.md                   ← Feature checklist
└── DATABASE_SCHEMA.md                   ← Database documentation
```

---

## 🔑 Key Files Created

### Migrations (11 files)
- ✅ `2025_12_15_*_create_users_table.php` - User dengan 3 roles
- ✅ `2025_12_15_*_create_categories_table.php` - Kategori produk
- ✅ `2025_12_15_*_create_products_table.php` - Produk dengan 3 harga
- ✅ `2025_12_15_*_create_carts_table.php` - Keranjang belanja
- ✅ `2025_12_15_*_create_orders_table.php` - Pesanan customer
- ✅ `2025_12_15_*_create_order_items_table.php` - Item dalam pesanan
- ✅ `2025_12_15_*_create_payments_table.php` - Pembayaran & bukti
- ✅ `2025_12_15_*_create_price_tiers_table.php` - Tier harga fleksibel
- ✅ `2025_12_15_*_create_store_settings_table.php` - Informasi toko
- ✅ `0001_01_01_*_create_cache_table.php` - Cache
- ✅ `0001_01_01_*_create_jobs_table.php` - Queue jobs

### Models (8 files)
- ✅ User.php - User dengan relationships
- ✅ Product.php - Produk dengan relationships
- ✅ Category.php - Kategori
- ✅ Cart.php - Keranjang
- ✅ Order.php - Pesanan
- ✅ OrderItem.php - Item pesanan
- ✅ Payment.php - Pembayaran
- ✅ PriceTier.php - Tier harga
- ✅ StoreSetting.php - Setting toko

### Controllers (14 files)
**Auth (3):**
- ✅ Auth/AuthController.php - Login/Logout
- ✅ Auth/RegisterController.php - Registrasi
- ✅ Auth/ForgotPasswordController.php - Reset password

**Customer (5):**
- ✅ Customer/HomeController.php - Home & dashboard
- ✅ Customer/ProductController.php - Katalog produk
- ✅ Customer/CartController.php - Keranjang
- ✅ Customer/CheckoutController.php - Checkout
- ✅ Customer/PaymentController.php - Pembayaran

**Admin (4):**
- ✅ Admin/DashboardController.php - Dashboard
- ✅ Admin/ProductController.php - CRUD produk
- ✅ Admin/OrderController.php - Verifikasi pesanan
- ✅ Admin/ReportController.php - Laporan keuangan

**Owner (3):**
- ✅ Owner/DashboardController.php - Dashboard
- ✅ Owner/CustomerController.php - CRUD customer
- ✅ Owner/ReportController.php - Laporan

### Middleware (3 files)
- ✅ AdminMiddleware.php - Check role='admin'
- ✅ OwnerMiddleware.php - Check role='owner'
- ✅ CustomerMiddleware.php - Check role='customer'

### Routes
- ✅ routes/web.php - 60+ routes dengan role-based grouping

---

## 🎯 Next Steps

### 1. Implement Controllers (Most Important!)
Lihat `IMPLEMENTATION_GUIDE.md` untuk code template untuk setiap controller.

```php
// Contoh: AuthController.php
namespace App\Http\Controllers\Auth;

class AuthController extends Controller {
    public function showLogin() {
        return view('auth.login');
    }
    
    public function login(Request $request) {
        // Validate & authenticate
    }
}
```

### 2. Create Blade Views
Buat folder `resources/views` dan sub-folders:

```bash
mkdir resources/views/layouts
mkdir resources/views/auth
mkdir resources/views/customer
mkdir resources/views/admin
mkdir resources/views/owner
```

Contoh view structure:
```blade
{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Grosir Berkat Ibu')</title>
</head>
<body>
    @include('layouts.navbar')
    
    <main class="container">
        @yield('content')
    </main>
    
    @include('layouts.footer')
</body>
</html>
```

### 3. Add Styling
Recommend: Tailwind CSS atau Bootstrap

```bash
# Install Tailwind CSS
npm install -D tailwindcss postcss autoprefixer
npx tailwindcss init -p

# Or use Bootstrap via CDN
```

### 4. Database Seeding
Buat seeders untuk test data:

```bash
php artisan make:seeder CategorySeeder
php artisan make:seeder ProductSeeder
php artisan make:seeder UserSeeder
```

### 5. File Upload
Setup storage untuk gambar:

```bash
php artisan storage:link
```

Update config/filesystems.php jika perlu.

---

## 📝 Common Commands

```bash
# Development
php artisan serve                   # Start dev server
php artisan migrate                 # Run migrations
php artisan migrate:fresh          # Reset database
php artisan tinker                 # Interactive shell

# Generate files
php artisan make:controller         # Create controller
php artisan make:model -m           # Create model + migration
php artisan make:middleware         # Create middleware

# Database
php artisan db:seed                # Run seeders
php artisan seed:refresh           # Reset & seed

# Maintenance
php artisan cache:clear            # Clear cache
php artisan config:cache           # Cache config
php artisan route:cache            # Cache routes

# Production
php artisan config:cache           # Production optimization
php artisan route:cache
php artisan view:cache
php artisan storage:link
```

---

## 🧪 Test Data Commands

```bash
# Create test users
php artisan tinker

# Admin
App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@test.com',
    'role' => 'admin',
    'phone' => '08123456789',
    'password' => bcrypt('admin123')
]);

# Owner
App\Models\User::create([
    'name' => 'Owner',
    'email' => 'owner@test.com',
    'role' => 'owner',
    'phone' => '08987654321',
    'password' => bcrypt('owner123')
]);

# Customer
App\Models\User::create([
    'name' => 'Customer 1',
    'email' => 'customer1@test.com',
    'role' => 'customer',
    'phone' => '08111111111',
    'province' => 'Jawa Barat',
    'city' => 'Bandung',
    'district' => 'Cihampelas',
    'address' => 'Jl. Test No. 123',
    'password' => bcrypt('customer123')
]);

# Store settings
App\Models\StoreSetting::create([
    'store_name' => 'Grosir Berkat Ibu',
    'phone' => '08123456789',
    'address' => 'Jl. Contoh No. 123',
    'province' => 'Jawa Barat',
    'city' => 'Bandung',
    'district' => 'Cihampelas',
    'maps_url' => 'https://maps.google.com/...'
]);

# Category
$cat = App\Models\Category::create([
    'name' => 'Makanan',
    'description' => 'Produk makanan'
]);

# Product
App\Models\Product::create([
    'name' => 'Minyak Goreng 2L',
    'description' => 'Minyak goreng berkualitas',
    'category_id' => $cat->id,
    'price_unit' => 25000,
    'price_bulk_4' => 24000,
    'price_dozen' => 23000,
    'stock' => 100
]);

exit
```

---

## 🔍 Verify Installation

```bash
# Check migrations ran successfully
php artisan migrate:status

# Check models work
php artisan tinker
App\Models\Product::count()
App\Models\User::where('role', 'admin')->count()
exit

# Check routes defined
php artisan route:list | grep customer
php artisan route:list | grep admin
```

---

## 📚 Resource Links

- **Laravel Docs**: https://laravel.com/docs
- **Laravel Blade**: https://laravel.com/docs/blade
- **Eloquent ORM**: https://laravel.com/docs/eloquent
- **Authentication**: https://laravel.com/docs/authentication
- **File Storage**: https://laravel.com/docs/filesystem

---

## ⚠️ Common Issues & Solutions

### Issue: Migrations not running
```bash
# Solution:
php artisan migrate --force
```

### Issue: Middleware not working
```bash
# Check bootstrap/app.php has middleware aliases
# Clear config cache
php artisan config:clear
```

### Issue: View not found
```bash
# Check view path in controller
return view('customer.home');  // resources/views/customer/home.blade.php

# Check file exists
ls resources/views/customer/home.blade.php
```

### Issue: Storage files not accessible
```bash
# Link storage to public
php artisan storage:link

# Check symlink created
ls -la public/storage
```

---

## 🎓 Learning Path

1. **Understand Database Schema** → Read `DATABASE_SCHEMA.md`
2. **Understand Code Structure** → Read `README.md`
3. **Implement Controllers** → Follow `IMPLEMENTATION_GUIDE.md`
4. **Create Views** → Reference Laravel Blade docs
5. **Add Styling** → Use Tailwind or Bootstrap
6. **Test Everything** → Manual testing checklist
7. **Deploy** → Follow deployment checklist

---

## 📞 Support & Help

**Need Help?**
- Check documentation files (README.md, IMPLEMENTATION_GUIDE.md, etc.)
- Read Laravel official documentation
- Use `php artisan tinker` for quick testing

**Documentation Files:**
- 📄 README.md - Overview
- 📄 IMPLEMENTATION_GUIDE.md - Code templates
- 📄 SETUP_CHECKLIST.md - Feature checklist
- 📄 DATABASE_SCHEMA.md - Database design
- 📄 QUICK_START.md - This file

---

**Good luck with development! 🚀**

**Created:** December 15, 2025  
**Version:** 1.0.0
