# ⚡ DEV QUICK START - 30 Seconds to Testing

## 🚀 Start Here

```bash
# Terminal 1: Start server
php artisan serve

# Output: http://127.0.0.1:8000
```

## 🔓 Quick Login (Pick One)

### Option A: Use Command
```bash
php artisan dev:login admin      # Show admin credentials
php artisan dev:login customer   # Show customer credentials  
php artisan dev:login siti       # Show siti credentials
```

### Option B: Direct Credentials
```
ADMIN:
  Email: admin@grosir.com
  Pass:  password123

CUSTOMER:
  Email: budi@example.com
  Pass:  password123
```

## 🌐 Open Browser
Go to: **http://127.0.0.1:8000/login**

---

## 📋 Test Scenarios

### 1️⃣ Customer Checkout (5 mins)
- Login as `budi@example.com`
- Browse products
- Add to cart
- Checkout
- Upload payment proof
- See order in history

### 2️⃣ Admin Approval (5 mins)
- Login as `admin@grosir.com`
- Go to Orders
- Click Verify on pending order
- See payment proof
- Approve/Reject
- Check stock updated

### 3️⃣ Test Security (2 mins)
- Create 2 orders (budi + siti)
- Try accessing other user's invoice URL
- See 403 Forbidden ✅

### 4️⃣ Test Stock Locking (3 mins)
- Create 2 browser tabs (different accounts)
- Same product, low stock
- Both checkout same time
- One succeeds, one fails ✅

---

## 🔄 Reset Data Anytime

```bash
php artisan migrate:fresh --seed
```

Back to fresh database with test data.

---

## 📊 What's Available

✅ 4 test users (admin, owner, 2 customers)  
✅ 20+ products with pricing tiers  
✅ All 5 critical fixes applied  
✅ Full payment workflow  
✅ Admin verification system  

---

## 🆘 If Something's Wrong

```bash
# Clear all caches
php artisan config:clear && php artisan route:clear

# Check logs (Terminal 2)
tail -f storage/logs/laravel.log

# Kill & restart server
# (Ctrl+C in Terminal 1, then: php artisan serve)
```

---

**Ready?** Just run `php artisan serve` and open http://127.0.0.1:8000 🚀
