# 🧪 QUICK TESTING GUIDE - Grosir Berkat Ibu

## Test Credentials

```
ADMIN ACCOUNT:
Email: admin@grosir.com
Password: password123

OWNER ACCOUNT:
Email: owner@grosir.com
Password: password123

CUSTOMER ACCOUNTS:
Email: budi@example.com
Password: password123

(Or register new customer account)
```

---

## 🧪 **TEST FLOW 1: View Product with Smart Pricing**

### Steps:
1. **Go to:** http://127.0.0.1:8000
2. **Click:** Login (top right)
3. **Login as:** budi@example.com / password123
4. **Click:** Produk (Products menu)
5. **Click on:** Any product (e.g., "Mie Indomie Goreng")
6. **Observe:**
   - ✅ See 3 colored price boxes (Yellow/Blue/Green)
   - ✅ Shows % savings for each tier
   - ✅ Shows effective unit price for Box tier
7. **Test Price Preview:**
   - Enter: `3` → Should show "Satuan: Rp X/pcs"
   - Enter: `5` → Should show "Grosir: Rp X/pcs" (cheaper)
   - Enter: `15` → Should show "Dus: Rp X/pcs" (cheapest)

**Expected Output Example:**
```
Quantity Input: 5
↓
Tier: Grosir
Harga Grosir (min. 4 Pcs)
Total: Rp 33.000 ✅
```

---

## 🛒 **TEST FLOW 2: Add to Cart & Checkout**

### Step 1: Add Products with Different Quantities
1. Browse to product detail page
2. **Test 1:** Input Qty=2, Add to Cart
3. **Test 2:** Go back, select different product
4. **Test 3:** Input Qty=5, Add to Cart
5. **Test 4:** Go back, select another product
6. **Test 4:** Input Qty=12, Add to Cart

### Step 2: View Cart
1. **Click:** Cart (header)
2. **Observe:**
   - ✅ All 3 items listed
   - ✅ Original quantities shown (2, 5, 12)
   - ✅ Can modify quantities (if needed)

### Step 3: Checkout
1. **Click:** Checkout button
2. **Observe Order Breakdown:**
   - ✅ Item 1: 2 qty → Satuan tier → shows effective price
   - ✅ Item 2: 5 qty → Grosir tier → shows effective price
   - ✅ Item 3: 12 qty → Dus tier → shows effective price
   - ✅ Each item shows tier badge (Satuan/Grosir/Dus)
   - ✅ Subtotal calculation is correct
3. **Fill Shipping Details:**
   - Name: [Fill in]
   - Phone: [Fill in]
   - Address: [Fill in]
4. **Select Shipping:** GoSend (auto-adds Rp 15.000)
5. **Select Payment:** Transfer Bank
6. **Click:** Lanjut ke Pembayaran (Continue to Payment)

### Step 4: Verify Database
Open terminal:
```bash
php artisan tinker

# Check order was created
> $order = Order::latest()->first();
> $order->invoice_number;  # Should see: INV/2025/12/XXXX
> $order->total_amount;    # Should match checkout total

# Check order items have price snapshots
> $order->items()->get();
> // Should see 'unit_price' field with locked-in price

# Check stock was deducted
> $product = Product::find(1);
> $product->stock;  # Should be reduced by purchase qty
```

---

## 💰 **TEST FLOW 3: Price Tier Verification**

### Setup Test Product:
```
Product: Test Indomie
├─ Price Unit: 3.500
├─ Price Bulk (4+): 3.300
├─ Price Dozen: 120.000 (for 40 pcs)
└─ Box Item Count: 40
```

### Test Cases:

**Test Case 1: Unit Tier (1-3)**
```
Qty: 2
Expected: Satuan (Unit) tier
Expected Price: 3.500/pcs
Expected Total: 7.000 ✅
```

**Test Case 2: Wholesale Tier (4-39)**
```
Qty: 10
Expected: Grosir (Wholesale) tier
Expected Price: 3.300/pcs
Expected Total: 33.000 ✅
```

**Test Case 3: Box Tier (40+)**
```
Qty: 50
Expected: Dus (Box) tier
Expected Effective Price: 120.000 ÷ 40 = 3.000/pcs
Expected Total: 150.000 ✅
```

**Test Case 4: Fractional Division (Edge Case)**
```
Product: Widget
├─ Price Dozen: 100.000
└─ Box Count: 3

Qty: 5
Expected: Dus tier
Expected Calculation: 100.000 ÷ 3 = 33.333...
Expected Final Price: 33.333 (rounded) ✅
NOT: 33.333,33 ❌
```

---

## 🔄 **TEST FLOW 4: Transaction Rollback (Error Handling)**

### Scenario: Simulate Stock Shortage

**Setup:**
1. Add product to cart (Qty = 1000 pcs, but stock only 500)

**Expected Behavior:**
- ✅ Transaction should detect error
- ✅ Order NOT created
- ✅ Stock NOT deducted
- ✅ User sees error message

```bash
# To test: Manually set insufficient stock
php artisan tinker
> $p = Product::find(1);
> $p->stock = 5;  # Reduce stock
> $p->save();

# Now try checkout with qty=10
# Expected: Order creation fails, stock unchanged
```

---

## 📊 **TEST FLOW 5: Price Snapshot Verification**

### Objective: Verify price doesn't change after purchase

**Setup:**
1. Customer buys 5 pcs at Rp 3.300/pcs = Rp 16.500
2. Admin updates product price to Rp 4.000

**Test Steps:**
```bash
# Step 1: Check order items price
php artisan tinker
> $item = OrderItem::first();
> $item->unit_price;  # Shows: 3300 (locked in) ✅

# Step 2: Update product price
> $product = Product::find($item->product_id);
> $product->price_bulk_4 = 4000;
> $product->save();

# Step 3: Verify order item price unchanged
> $item->fresh();
> $item->unit_price;  # Still shows: 3300 ✅
```

**Expected Result:**
```
Order items keep original price: Rp 3.300
Product new price: Rp 4.000
✅ Snapshot is isolated from future price changes
```

---

## 🔐 **TEST FLOW 6: Admin Product Management**

### Create New Product with 3-Tier Pricing

1. **Login as:** admin@grosir.com
2. **Go to:** Admin → Products → Create
3. **Fill Form:**
   ```
   Name: Mie Sedap Goreng
   Description: Mie goreng sedap, pedas dan nikmat
   Category: Mie Instan
   Price Unit: 3000
   Price Bulk (4+): 2800
   Price Dozen: 110000
   Stock: 1000
   Unit: Pcs
   Box Item Count: 40
   ```
4. **Upload Image:** Select product image (max 2MB)
5. **Click:** Save
6. **Expected:**
   - ✅ Product created
   - ✅ Slug auto-generated: "mie-sedap-goreng"
   - ✅ Image uploaded to public/storage/products/
   - ✅ Appears in product list

---

## 📋 **TEST CHECKLIST**

- [ ] Product detail shows 3-tier pricing
- [ ] Price preview calculates correctly in real-time
- [ ] Can add to cart with different quantities
- [ ] Cart maintains quantities
- [ ] Checkout shows correct tier for each item
- [ ] Shipping cost updates dynamically
- [ ] Order is created with correct total
- [ ] Invoice number generated (INV/YYYY/MM/XXXX format)
- [ ] Price snapshots saved to order_items
- [ ] Stock correctly deducted (in PCS)
- [ ] Price doesn't change if product price updates
- [ ] Transaction rolls back on error
- [ ] Admin can create products with tiered pricing
- [ ] Image upload works (max 2MB)
- [ ] Slug auto-generates correctly

---

## 🐛 **TROUBLESHOOTING**

### Issue: Price shows decimal (Rp 33.333,33)
**Solution:** Check `PricingHelper::calculateItemPrice()` uses `round(..., 0)`

### Issue: Stock not deducting correctly
**Solution:** Verify `CheckoutController` uses `$product->box_item_count` NOT hardcoded 12

### Issue: Price changes on old orders
**Solution:** Verify `OrderItem` stores `unit_price` (snapshot) NOT just `product_id`

### Issue: Checkout fails with transaction error
**Solution:** Check database has `order_items.unit_price` column and `orders.invoice_number`

### Issue: Images not displaying
**Solution:** Run `php artisan storage:link`

---

## 📞 **QUICK REFERENCE**

```bash
# Start fresh
php artisan migrate:fresh --seed

# Access database
php artisan tinker

# Check routes
php artisan route:list

# Clear cache if issues
php artisan cache:clear
php artisan config:clear
```

---

**Last Updated:** December 15, 2025
**Status:** Ready for Testing ✅
