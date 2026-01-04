# 🎯 DEV CHEAT SHEET - All Commands & Routes

## ⚡ Essential Commands

### Server Management
```bash
# Start development server
php artisan serve
# Output: http://127.0.0.1:8000

# Reset database with fresh data
php artisan migrate:fresh --seed

# Clear all caches
php artisan config:clear && php artisan route:clear
```

### Quick Login
```bash
# Show credentials for any role
php artisan dev:login admin       # Admin credentials
php artisan dev:login owner       # Owner credentials  
php artisan dev:login customer    # Customer credentials
php artisan dev:login budi        # Specific customer (budi)
php artisan dev:login siti        # Specific customer (siti)
```

### Database
```bash
# Run all migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Fresh database (delete all data)
php artisan migrate:fresh

# Fresh + seed test data
php artisan migrate:fresh --seed

# Check migrations
php artisan migrate:status
```

### Development Utils
```bash
# Run tests
php artisan test

# Check syntax
php -l app/Http/Controllers/Admin/OrderController.php

# Tinker (interactive console)
php artisan tinker
```

---

## 🌐 Important Routes

### Public Routes
```
GET  /                              Home page (public landing)
GET  /login                         Login page
POST /login                         Process login
GET  /register                      Register page
POST /register                      Process registration
GET  /orders/{invoice}/payment      Payment upload page
```

### Customer Routes (After Login)
```
GET  /customer/dashboard            Customer dashboard
GET  /customer/products             Browse products
POST /customer/cart/{product}       Add to cart
GET  /customer/cart                 View cart
POST /customer/checkout             Process checkout
GET  /customer/orders               Order history
POST /customer/payment/{id}/upload  Upload payment proof
```

### Admin Routes (After Login)
```
GET  /admin                         Admin dashboard
GET  /admin/orders                  All orders
GET  /admin/orders/{id}/verify      Verify payment (split screen)
POST /admin/orders/{id}/approve     Approve payment
POST /admin/orders/{id}/reject      Reject payment
POST /admin/orders/{id}/ship        Mark shipped
POST /admin/orders/{id}/complete    Mark completed
```

### Owner Routes (After Login)
```
GET  /owner                         Owner dashboard
GET  /owner/reports                 Reports page
```

---

## 🧪 Testing Workflows

### Test #1: Complete Purchase Flow (Admin + Customer)

**Terminal 1: Start Server**
```bash
php artisan serve
```

**Terminal 2: Get Credentials**
```bash
php artisan dev:login customer
php artisan dev:login admin
```

**Browser: Customer Flow**
1. Open: http://127.0.0.1:8000/login
2. Login with: `budi@example.com` / `password123`
3. Go to: Customer > Products
4. Add item to cart
5. Checkout → Fill form → Submit
6. Upload payment proof
7. See order in "Order History"

**Browser: Admin Flow (New Tab)**
1. Open: http://127.0.0.1:8000/login
2. Login with: `admin@grosir.com` / `password123`
3. Go to: Admin > Orders
4. Click "Verify" on pending order
5. See payment proof on left, order details on right
6. Click "Approve" or "Reject"
7. Check order status updated

### Test #2: Concurrent Checkout (Race Condition)

**Setup:**
- Product stock: 5 pcs
- Customer 1 & 2 add 4 pcs to cart

**Test Steps:**
1. Open 2 browser windows (different sessions)
2. Window 1: Login as budi
3. Window 2: Login as siti
4. Both add same product (4 pcs) to cart
5. Both click checkout at same time
6. **Expected Result:**
   - One succeeds (Rp ... total)
   - One fails (error: "Stok tidak cukup")

### Test #3: Security - Invoice Enumeration

**Test:**
1. Login as budi → Create order
2. Get invoice number (e.g., INV/2025/12/0001)
3. Logout
4. Try to access: `/orders/INV/2025/12/0001/payment`
5. **Expected:** 403 Forbidden error

### Test #4: Pricing Tiers

**Test:**
1. Login as customer
2. Add 1 item to cart → Subtotal = Normal price
3. Add 3 more items (total 4) → Should show Tier 2 (10% discount)
4. Add 2 more items (total 6) → Should show Tier 3 (15% discount)

---

## 📊 Database Queries (Tinker)

### Check User
```bash
php artisan tinker

>>> User::find(1);
>>> User::where('email', 'admin@grosir.com')->first();
```

### Check Orders
```bash
>>> Order::with('user', 'items', 'payment')->latest()->get();
>>> Order::where('status', 'pending')->count();
```

### Check Stock
```bash
>>> Product::where('stock', '<', 0)->get();  # Should be empty
>>> Product::where('id', 1)->first()->stock;
```

### Check Payment
```bash
>>> Payment::with('order')->latest()->get();
>>> Payment::where('status', 'verified')->count();
```

### Create Order Manually
```bash
>>> $user = User::find(2);  # Customer
>>> $product = Product::find(1);
>>> $order = Order::create(['user_id' => 2, ...]);
>>> $order->items()->create(['product_id' => 1, 'quantity' => 5]);
```

---

## 🔍 Debugging

### Check Logs
```bash
# Terminal: Watch logs in real-time
tail -f storage/logs/laravel.log

# See recent errors
tail -20 storage/logs/laravel.log
```

### Debug in Code
```php
// In any controller
dd($variable);       // Dump & die
dump($variable);     // Dump only
Log::info('text');   // Write to logs
```

### Laravel Debugbar (If Installed)
Look for black bar at bottom of browser showing:
- DB queries executed
- Time taken
- Variables available
- Route info

---

## 🚨 Common Issues & Fixes

### Issue: "No application encryption key has been set"
```bash
php artisan key:generate
```

### Issue: "SQLSTATE[HY000]: General error"
```bash
php artisan migrate:fresh --seed
# Or check database connection in .env
```

### Issue: Routes not updating
```bash
php artisan route:cache --clear
# Or clear routes
php artisan route:clear
```

### Issue: Config not updating
```bash
php artisan config:clear
```

### Issue: Server won't start
```bash
# Kill existing PHP processes
# Then restart:
php artisan serve
```

---

## 📁 Key Files to Edit

**Controllers:**
- `app/Http/Controllers/Admin/OrderController.php` - All order operations
- `app/Http/Controllers/Customer/CheckoutController.php` - Checkout logic
- `app/Http/Controllers/Auth/AuthController.php` - Login/logout

**Models:**
- `app/Models/Order.php` - Order model
- `app/Models/Product.php` - Product model
- `app/Models/User.php` - User model

**Views:**
- `resources/views/admin/orders/` - Admin order pages
- `resources/views/customer/` - Customer pages
- `resources/views/auth/` - Auth pages

**Config:**
- `config/shipping.php` - Shipping settings
- `routes/web.php` - All routes

---

## 💡 Pro Tips

1. **Always check logs first**
   ```bash
   tail -f storage/logs/laravel.log
   ```

2. **Use Tinker for quick testing**
   ```bash
   php artisan tinker
   >>> User::all();
   ```

3. **Keep server running in background**
   - Terminal 1: `php artisan serve`
   - Terminal 2: Main work
   - Terminal 3: `tail -f storage/logs/laravel.log`

4. **Use browser's network tab**
   - Chrome DevTools > Network
   - See all requests, responses, status codes

5. **Test API with Postman/Insomnia**
   - Test checkout without UI
   - Test payment endpoints
   - Check error handling

---

## ✅ Pre-Launch Checklist

- [ ] All 5 critical fixes applied ✅
- [ ] Database fresh seeded
- [ ] Server running without errors
- [ ] Can login as admin
- [ ] Can login as customer
- [ ] Checkout flow works
- [ ] Admin approval works
- [ ] Stock updates correctly
- [ ] No negative stocks
- [ ] Cannot see other users' orders
- [ ] Security tests pass

---

**Happy developing!** 🚀
