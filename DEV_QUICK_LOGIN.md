# 🚀 QUICK LOGIN - Development Guide

## Test Akun Tersedia

Database sudah di-seed dengan test accounts berikut:

### 👨‍💼 **ADMIN**
```
Email:    admin@grosir.com
Password: password123
Role:     Admin (dapat verify pembayaran, approve order, lihat laporan)
```

### 👔 **OWNER**
```
Email:    owner@grosir.com
Password: password123
Role:     Owner (dapat lihat dashboard owner, manage setting)
```

### 🛍️ **CUSTOMER #1**
```
Email:    budi@example.com
Password: password123
Role:     Customer (dapat checkout, lihat order history)
```

### 👩‍💼 **CUSTOMER #2**
```
Email:    siti@example.com
Password: password123
Role:     Customer
```

---

## Cara Cepat Test

### 1️⃣ Start Server
```bash
php artisan serve
```
Server akan jalan di: **http://127.0.0.1:8000**

### 2️⃣ Buka Login
Kunjungi: **http://127.0.0.1:8000/login**

### 3️⃣ Gunakan Test Credentials
- **Admin Testing:** Gunakan `admin@grosir.com` / `password123`
- **Customer Testing:** Gunakan `budi@example.com` / `password123`

### 4️⃣ Test Workflow

**Sebagai Customer:**
1. Login dengan `budi@example.com`
2. Go to **Customer > Products**
3. Add items ke cart
4. Go to **Checkout**
5. Fill form → Submit
6. Upload payment proof
7. Go to **Order History** untuk lihat status

**Sebagai Admin:**
1. Login dengan `admin@grosir.com`
2. Go to **Admin > Orders**
3. Lihat pending orders
4. Click **Verify** button
5. Lihat payment proof & order details
6. **Approve** atau **Reject** order
7. Jika approve → stok berkurang, order ke "processing"

---

## Reset Database dengan Fresh Seeder

Jika ingin reset database & load test data ulang:

```bash
# Hapus semua data & run seeder
php artisan migrate:fresh --seed

# Output: All 14 migrations passed + seeders executed
```

Setelah ini, semua test accounts tersedia kembali.

---

## Database Status

### ✅ Seeded Data
- **4 Users** (1 admin, 1 owner, 2 customers)
- **5 Categories** (Dry goods, spices, snacks, etc)
- **20+ Products** (dengan stock, pricing tiers, box_item_count)
- **Store Settings** (shipping methods, store info)

### ✅ Test Scenario Ready
- Customer can checkout
- Admin can verify payment
- Stock deduction works
- Race condition protected (lockForUpdate)
- Privacy protected (ownership check)

---

## Useful Quick Commands

```bash
# Start dev server
php artisan serve

# Fresh database with seeder
php artisan migrate:fresh --seed

# Clear cache
php artisan config:clear
php artisan route:clear

# Check routes
php artisan route:list | grep -E "login|admin|customer"

# Tail logs (in another terminal)
tail -f storage/logs/laravel.log
```

---

## Tips for Development

### 🎯 Fastest Testing Cycle
1. Terminal 1: `php artisan serve`
2. Terminal 2: Keep browser open to http://127.0.0.1:8000
3. Terminal 3: `tail -f storage/logs/laravel.log` (untuk debug)

### 🧪 Testing Payment Flow
1. Login sebagai customer
2. Create order & upload payment proof
3. Switch ke admin account (open new browser/incognito)
4. Login sebagai admin
5. Verify payment from admin panel
6. Check customer order status updated

### 🔄 Testing Race Condition
1. Create 2 sessions (customer1 & customer2)
2. Kedua cart punya same product (sisa stok 5)
3. Kedua mulai checkout pada waktu bersamaan
4. Verify: 1 succeed, 1 fail dengan error "stok tidak cukup"

### 🔐 Testing Security
1. Login sebagai customer1
2. Get invoice number dari order history
3. Logout
4. Manual edit URL ke customer2's invoice
5. Verify: 403 Forbidden (cannot see other user's order)

---

## Troubleshooting

### "Route [customer.home] not defined" error
❌ **Old Issue** - Already FIXED (changed to customer.dashboard)

### Can't login?
✅ Make sure database is seeded:
```bash
php artisan migrate:fresh --seed
```

### Getting 403 on payment page?
✅ That's **correct** behavior - nur owner dapat lihat their own payment

### Stock showing negative?
❌ **Bug** - Should NOT happen (lockForUpdate now prevents this)

---

## 📊 Test Data Overview

```
CATEGORIES:
- Makanan Kering (Dry Goods)
- Bumbu & Rempah (Spices)  
- Snack & Cemilan (Snacks)
- Minuman (Beverages)
- Perlengkapan Rumah (Home)

PRODUCTS (Sample):
- Indomie Goreng (Rp 13.900) → Stock: 100 pcs, 12/box
- Minyak Goreng (Rp 95.000) → Stock: 30 liter
- Gula (Rp 89.900) → Stock: 50 kg
- Garam (Rp 12.900) → Stock: 200 packs
- Coffee (Rp 45.000) → Stock: 80 packs

PRICING TIERS:
- 1-3 items: Normal price
- 4-5 items: Tier 2 discount (10% off)
- 6+ items: Tier 3 discount (15% off)
```

---

## Next Steps After Quick Testing

1. ✅ Test all 5 critical fixes (duplikasi controller, enumeration, register, shipping, race condition)
2. ✅ Manual test checkout flow
3. ✅ Admin verification system
4. ✅ Payment upload & proof
5. 🎯 Load testing (concurrent orders)
6. 🎯 Security testing (penetration test)
7. 🎯 Production deployment

---

**Ready to code?** Start with:
```bash
php artisan serve
```

Then open: http://127.0.0.1:8000/login

Happy developing! 🚀
