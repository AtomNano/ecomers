# TESTING GUIDE - SECURITY & LOGIC FIXES

## Pre-Deployment Testing Checklist

### Test 1: Controller Merger Validation (Fix #1)
**Objective:** Verify that approve/reject logic works from single OrderController

**Steps:**
1. Login as admin at `http://127.0.0.1:8000/login`
2. Navigate to `/admin/orders`
3. Click verify/approve button on pending order
4. **Expected:** Order moves to "processing" status, stok berkurang
5. Click reject button on pending order
6. **Expected:** Order cancelled, stok dikembalikan

**Verification:**
- [ ] Approve redirects properly
- [ ] Reject redirects properly
- [ ] Stock updates reflected correctly
- [ ] No AdminOrderController errors in logs

---

### Test 2: Invoice Enumeration Fix (Fix #2)
**Objective:** Verify that users cannot access other users' orders

**Steps:**
1. **Setup:** Create 2 test customers
   - Customer A: registers account
   - Customer B: registers account
2. **Customer A:** Create order, get invoice number (e.g., `INV/2025/12/0001`)
3. **Customer B:** Try to access Customer A's payment page
   - Go to `/orders/INV/2025/12/0001/payment`
4. **Expected:** 
   - If logged in as B: `403 Forbidden - Anda tidak berhak melihat pesanan ini`
   - If not logged in: Should either redirect to login OR show 403

**Verification:**
- [ ] Can access own orders
- [ ] Cannot access other users' orders (logged in)
- [ ] Cannot enumerate invoices (sequential guessing fails)

---

### Test 3: Register Flow (Fix #3)
**Objective:** Verify that registration redirects to correct dashboard

**Steps:**
1. Go to `/register`
2. Fill form:
   ```
   Name: John Doe
   Email: john@example.com
   Password: password123
   Confirm: password123
   Phone: 081234567890
   Province: Jawa Timur
   City: Surabaya
   District: Rungkut
   Address: Jln Test No 123
   ```
3. Click Submit
4. **Expected:** Redirected to `/customer/dashboard` (NOT error page)
5. **Expected:** Success message "Registrasi berhasil!" visible

**Verification:**
- [ ] Form submits without 500 error
- [ ] Redirects to customer.dashboard
- [ ] User logged in after registration
- [ ] Dashboard loads properly

---

### Test 4: Shipping Config (Fix #4)
**Objective:** Verify shipping costs are read from config, not hardcoded

**Steps:**
1. Login as customer
2. Add product to cart
3. Go to checkout
4. Select "Go Send" shipping method
5. **Expected:** Shipping cost = Rp 15.000 (from config)
6. Verify in code: `config/shipping.php` has correct amounts

**Verification:**
- [ ] Shipping cost matches config/shipping.php value
- [ ] Can change config value and see update (no redeploy needed)
- [ ] All shipping methods show correct costs

**Manual Config Test:**
```bash
# Edit config/shipping.php
# Change 'gosend' => ['cost' => 15000] to ['cost' => 25000]
# Reload checkout page
# Should show Rp 25.000 without deploying
```

---

### Test 5: Race Condition Prevention (Fix #5) - CRITICAL
**Objective:** Verify that concurrent orders don't cause overselling

**Scenario 1: Simple Lock Test**
1. **Setup:** Product with stok = 5 pcs
2. Customer A: Checkout 3 pcs
3. Customer B: Checkout 3 pcs simultaneously
4. **Expected:**
   - One succeeds, other gets error: "Stok tidak cukup"
   - Final stock = 2 pcs (either A or B gets it, not both)
   - NO negative stock

**Scenario 2: Load Test (Simulated Concurrency)**
```bash
# Using AB (Apache Bench) or similar load test tool
# Create checkout request file for 10 concurrent users

ab -n 10 -c 10 -p checkout.json \
   -T application/json \
   http://127.0.0.1:8000/customer/checkout
```

**Expected Results:**
- [ ] Max 1-2 orders succeed
- [ ] Others get "Stok tidak cukup" error
- [ ] Database stock is always >= 0
- [ ] No orphaned orders in database

**Database Verification:**
```sql
-- Check final stock
SELECT id, name, stock FROM products WHERE id = 1;
-- Should show: stock >= 0 (never negative)

-- Check order items
SELECT COUNT(*) FROM order_items WHERE product_id = 1;
-- Total quantity should NOT exceed original stock
```

---

### Test 6: Approval Flow with Locking (Fix #5 Admin Side)
**Objective:** Verify admin approval also uses locking

**Steps:**
1. **Setup:** Multiple pending orders with same product
2. Login as admin
3. Open 2 approval pages in different tabs (same product, low stock)
4. Tab 1: Approve order (uses 5 pcs, stok = 5)
5. Tab 2: Approve order (uses 8 pcs)
6. **Expected:**
   - One approval succeeds
   - Other fails: "Stok tidak cukup"
   - Stock never goes negative

**Verification:**
- [ ] First approval succeeds
- [ ] Second approval fails gracefully
- [ ] Stock accurately reflects approved orders

---

## Automated Testing (Optional)

### Laravel Feature Tests
```bash
php artisan test --filter=InvoiceEnumerationTest
php artisan test --filter=RaceConditionTest
php artisan test --filter=ControllerMergerTest
```

### Sample Test Code
```php
// tests/Feature/SecurityTest.php
public function test_cannot_access_other_users_orders()
{
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    
    $order = Order::factory()->create(['user_id' => $user1->id]);
    
    $response = $this->actingAs($user2)
        ->get("/orders/{$order->invoice_number}/payment");
    
    $response->assertStatus(403);
}

public function test_race_condition_stock_locking()
{
    $product = Product::factory()->create(['stock' => 10]);
    $user = User::factory()->create();
    
    // Simulate concurrent checkout
    // Expected: Only one succeeds, other rolls back
}
```

---

## Database Audit Queries

### Check Stock Integrity
```sql
-- Check for negative stock
SELECT id, name, stock FROM products WHERE stock < 0;

-- Should return: EMPTY (no negative stocks)
```

### Check Order History
```sql
-- Total stok yang diminta vs sisa
SELECT 
    p.id,
    p.name,
    p.stock as current_stock,
    SUM(oi.quantity) as total_ordered
FROM products p
LEFT JOIN order_items oi ON p.id = oi.product_id
GROUP BY p.id
HAVING SUM(oi.quantity) > (p.stock + SUM(oi.quantity))
-- Should return: EMPTY (no overselling)
```

### Audit Trail
```sql
-- Check stock adjustment logs
SELECT * FROM logs 
WHERE action = 'stock_returned' 
ORDER BY created_at DESC;

-- Should see all rejected orders' stock returns
```

---

## Manual Testing Checklist

### Before Going Live
- [ ] **Fix #1 - Controller:** Approve/Reject buttons work
- [ ] **Fix #2 - Security:** Cannot access other users' invoices
- [ ] **Fix #3 - Register:** Redirect to dashboard (no 500 error)
- [ ] **Fix #4 - Shipping:** Cost matches config file
- [ ] **Fix #5 - Stock:** Concurrent orders don't oversell
- [ ] **Database:** No negative stocks in table
- [ ] **Logs:** All actions properly logged
- [ ] **Error Handling:** Errors show user-friendly messages

### Performance Testing
- [ ] Checkout completes within 2-3 seconds
- [ ] Admin approval completes within 1-2 seconds
- [ ] No database deadlocks during concurrent operations
- [ ] Memory usage stable under load

### User Acceptance Testing
- [ ] Customer can complete full checkout flow
- [ ] Admin can verify and approve orders
- [ ] Rejected orders properly return stock
- [ ] Multiple customers can checkout simultaneously

---

## Rollback Plan (If Issues Found)

If any critical issue found:

```bash
# Revert specific file
git checkout HEAD -- app/Http/Controllers/Admin/OrderController.php
git checkout HEAD -- routes/web.php

# Or revert all changes
git reset --hard HEAD~1
```

---

## Post-Deployment Monitoring

### Server Logs
```bash
# Watch error logs
tail -f storage/logs/laravel.log

# Check for stock-related errors
grep -i "stock" storage/logs/laravel.log

# Check for security errors
grep -i "403\|forbidden\|unauthorized" storage/logs/laravel.log
```

### Performance Metrics
- Order checkout success rate
- Average checkout time
- Concurrent user handling
- Database query performance

### Alerts to Set Up
1. **Stock Alert:** If any product stock < 0
2. **Error Alert:** If 500 errors spike
3. **Security Alert:** If 403 errors spike (enumeration attempts)
4. **Performance Alert:** If checkout takes > 5s

---

## Success Criteria

All fixes are considered **SUCCESSFUL** when:

✅ No negative stock in database  
✅ Users cannot enumerate other users' invoices  
✅ Register flow completes without errors  
✅ Shipping cost from config file  
✅ Concurrent orders handled atomically  
✅ Admin approval/rejection works from single controller  
✅ No 500 errors in application  
✅ Load test shows proper locking behavior  

---

**Ready for Testing:** December 15, 2025  
**Server:** http://127.0.0.1:8000  
**Admin Panel:** http://127.0.0.1:8000/admin
