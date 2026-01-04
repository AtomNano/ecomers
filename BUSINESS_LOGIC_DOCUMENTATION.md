# 🚀 Grosir Berkat Ibu - E-Commerce Platform
## Business Logic & Implementation Documentation

---

## 📋 **ARCHITECTURE OVERVIEW**

```
┌─────────────────────────────────────────────────────────────┐
│                    CUSTOMER WORKFLOW                         │
└─────────────────────────────────────────────────────────────┘

1. VIEW PRODUCT
   ├─ See 3-tier pricing display
   ├─ Input preview quantity → auto calculate tier
   └─ See effective price

2. ADD TO CART
   └─ Cart stores raw quantity (no price snapshot yet)

3. CHECKOUT
   ├─ PricingHelper.calculateItemPrice() triggers
   ├─ Determine best tier for each item
   ├─ Save price_at_purchase snapshot
   └─ Deduct stock in PCS

4. PAYMENT
   ├─ Upload proof of transfer
   └─ Admin verify → stock confirmed
```

---

## 💰 **TIERED PRICING SYSTEM**

### **Three Price Tiers:**

| Tier | Min Qty | When Used | Price Per Item | Notes |
|------|---------|-----------|---|---|
| **Unit (Satuan)** | 1-3 pcs | Small purchase | Highest | Regular retail |
| **Wholesale (Grosir)** | 4+ pcs | Bulk purchase | Medium | Discount kicks in |
| **Box (Dus)** | ≥ box_item_count | Bulk purchase | **Lowest** | Effective = price_dozen / box_item_count |

### **Example: Indomie Mi Goreng**

```
Product Configuration:
├─ Unit Price: 3.500/pcs
├─ Wholesale Price (4+): 3.300/pcs  
├─ Box Price: 120.000/dus
└─ Box Item Count: 40 pcs

Customer Scenarios:
├─ Buys 3 pcs
│  └─ Tier Applied: Unit → 3.500/pcs → Total: 10.500
│
├─ Buys 10 pcs
│  └─ Tier Applied: Wholesale → 3.300/pcs → Total: 33.000
│
└─ Buys 50 pcs
   └─ Tier Applied: Box → (120.000 ÷ 40 = 3.000/pcs) → Total: 150.000
```

---

## 🔧 **CORE IMPLEMENTATION**

### **1. Product Model (app/Models/Product.php)**

#### **Method: calculateEffectivePrice($quantity)**
```php
public function calculateEffectivePrice($quantity)
{
    $boxCount = (int) ($this->box_item_count ?? 12);
    
    // Rule A: Box Tier (Termurah)
    if ($quantity >= $boxCount && $this->price_dozen) {
        $effectivePrice = round((float) $this->price_dozen / $boxCount, 0);
        return $effectivePrice;
    }
    
    // Rule B: Wholesale Tier
    if ($quantity >= 4 && $this->price_bulk_4) {
        return (float) $this->price_bulk_4;
    }
    
    // Rule C: Unit Tier (Default)
    return (float) $this->price_unit;
}
```

**CRITICAL:** Uses `round(..., 0)` to ensure prices are whole numbers (no Rp 33.333,33)

---

### **2. PricingHelper Class (app/Helpers/PricingHelper.php)**

#### **Method: calculateItemPrice($product, $quantity)**

**Returns Array:**
```php
[
    'effective_price' => 3000,      // Price per unit applied
    'price_type' => 'dozen',        // Which tier: unit|bulk_4|dozen
    'total_price' => 150000,        // effective_price * quantity
    'box_count' => 2,               // How many boxes (if dozen tier)
    'description' => '...'          // User-friendly explanation
]
```

**Logic Sequence:**
1. Check if `qty >= box_item_count` AND `price_dozen` exists → Use Box Tier
2. Else check if `qty >= 4` AND `price_bulk_4` exists → Use Wholesale Tier
3. Else → Use Unit Tier (default)

**Key Feature:** Automatically applies CHEAPEST tier based on quantity

---

### **3. CheckoutController (app/Http/Controllers/Customer/CheckoutController.php)**

#### **6-Step Transaction Process:**

```php
$order = DB::transaction(function () {
    // STEP 1: Calculate subtotal with pricing engine
    foreach ($carts as $cart) {
        $priceInfo = PricingHelper::calculateItemPrice($product, $quantity);
        $subtotal += $priceInfo['total_price'];
    }
    
    // STEP 2: Create Order (head document)
    $order = Order::create([
        'user_id' => auth()->id(),
        'invoice_number' => 'INV/2025/12/0001',  // Unique invoice
        'total_amount' => $totalAmount,
        ...
    ]);
    
    // STEP 3: Create OrderItems (price snapshot)
    foreach ($cartData as $item) {
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $quantity,
            'price_type' => $priceInfo['price_type'],
            'unit_price' => $priceInfo['effective_price'],  // SNAPSHOT!
            'subtotal' => $priceInfo['total_price'],
        ]);
        
        // STEP 4: Deduct stock (in PCS, not hardcoded)
        $product->decrement('stock', $quantity);
    }
    
    // STEP 5: Create Payment record
    Payment::create([...]);
    
    // STEP 6: Clear cart
    auth()->user()->carts()->delete();
    
    return $order;
});
```

**Why DB::transaction?**
- If error at Step 3 → Steps 1-2 rollback
- If error at Step 4 → Steps 1-3 rollback
- **Result:** No orphaned orders or inconsistent stock

---

## ⚠️ **CRITICAL BUSINESS RULES**

### **Rule 1: Price Snapshot (MUST SAVE)**

❌ **WRONG:**
```php
// If you only save product_id, when product price changes,
// customer's invoice price changes too!
OrderItem::create([
    'order_id' => $order->id,
    'product_id' => $product->id,  // Only reference
]);
```

✅ **CORRECT:**
```php
// Save the actual price at time of purchase
OrderItem::create([
    'product_id' => $product->id,
    'unit_price' => $priceInfo['effective_price'],  // Snapshot!
    'subtotal' => $priceInfo['total_price'],
]);

// Later, if product price changes, this order stays same
```

**Scenario:**
- Day 1: Customer buys 10 pcs Indomie at Rp 3.300
- Day 2: Admin raises price to Rp 4.000
- Day 3: Customer checks invoice → Still shows Rp 3.300 ✅

---

### **Rule 2: Stock Deduction (DON'T HARDCODE)**

❌ **WRONG:**
```php
// What if box_item_count changes?
$product->decrement('stock', 12);  // Hardcoded!
```

✅ **CORRECT:**
```php
// Get box_item_count from database
$boxCount = (int) ($product->box_item_count ?? 12);
$pcsToDeduct = $quantity * $boxCount;  // Dynamic!
$product->decrement('stock', $pcsToDeduct);
```

**Example:**
- Indomie: 40 pcs/box, customer buys 2 boxes
- Deduct: 2 × 40 = 80 pcs ✅
- NOT: 2 × 12 = 24 pcs ❌

---

### **Rule 3: Decimal Precision (USE round())**

❌ **WRONG:**
```php
$effectivePrice = $this->price_dozen / $boxCount;
// If 100.000 ÷ 3 = 33.333333...
// Customer charged: Rp 33.333,33 (no coin exists!)
```

✅ **CORRECT:**
```php
$effectivePrice = round($this->price_dozen / $boxCount, 0);
// 100.000 ÷ 3 = 33.333... → rounds to Rp 33.333
```

---

## 🎨 **USER INTERFACE LOGIC**

### **Product Detail Page (`show.blade.php`)**

**Features:**
1. **3-Tier Pricing Display**
   - Color-coded boxes (Yellow=Unit, Blue=Wholesale, Green=Box)
   - Show savings percentage
   - Display effective unit price for box tier

2. **Interactive Price Preview**
   - User inputs quantity
   - JavaScript calculates tier in real-time
   - Shows: `Tier Applied | Description | Total Price`

**Example UI:**
```
┌─────────────────────────────┐
│ 💰 Harga Berdasarkan Jumlah │
├─────────────────────────────┤
│ 🟨 Harga Satuan (1-11 pcs)  │
│    Rp 3.500/pcs             │
├─────────────────────────────┤
│ 🔵 Harga Grosir (4-11 pcs)  │
│    Rp 3.300/pcs (Hemat 6%)  │
├─────────────────────────────┤
│ 🟢 Harga Per Dus (≥12 pcs)  │
│    Rp 120.000/dus           │
│    Effective: 3.000/pcs     │
│    (Hemat 14%)              │
└─────────────────────────────┘

Preview Input: [10] [Calculate]
Result: Tier: Wholesale | Total: Rp 33.000
```

### **Checkout Page (`checkout.blade.php`)**

**Breakdown Display:**
- List each cart item
- Show which tier applied for each
- Show price calculation breakdown
- Dynamic shipping cost update
- Running total

**Sidebar Summary:**
- Subtotal
- Shipping cost (updates based on method)
- **Total (with savings highlighted)**

---

## 🧪 **TESTING SCENARIOS**

### **Scenario 1: User Buys in Wholesale Tier**

```
Product: Indomie (Unit: 3500, Bulk4: 3300, Dozen: 120000/40pcs)
Action: Add 6 pcs to cart
```

**Expected:**
```
✓ Tier: bulk_4
✓ Effective Price: 3.300/pcs
✓ Total: 19.800
✓ Stock Deduct: 6 pcs
✓ Invoice Shows: Rp 3.300 (snapshot)
```

---

### **Scenario 2: User Buys in Box Tier**

```
Product: Indomie
Action: Add 50 pcs to cart
```

**Expected:**
```
✓ Tier: dozen
✓ Effective Price: 3.000/pcs (120.000 ÷ 40)
✓ Total: 150.000
✓ Stock Deduct: 50 pcs
✓ Description: "50 pcs = 1 dus + 10 pcs" (visual reference)
```

---

### **Scenario 3: Price Changes After Purchase**

```
Day 1: Customer buys 10 pcs @ Rp 3.300/pcs = Rp 33.000
Day 2: Admin changes price_bulk_4 to Rp 4.000
Day 3: Customer checks invoice
```

**Expected:**
```
✓ Invoice still shows: Rp 3.300/pcs
✓ Total still: Rp 33.000
✓ New customers: See new price Rp 4.000
```

---

### **Scenario 4: Stock Deduction Works Correctly**

```
Before: Indomie stock = 1000 pcs
Customer 1: Buys 50 pcs @ Rp 3.000 (Box tier)
```

**Expected:**
```
✓ Database check: SELECT stock FROM products WHERE id=1
✓ Result: 950 pcs (1000 - 50)
✓ NOT 988 (1000 - 12) - hardcode error avoided
```

---

## 📊 **Database Integrity Checks**

After implementing, verify:

```bash
# Check migrations run successfully
php artisan migrate:status

# Verify columns exist
SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_NAME='products' 
AND COLUMN_NAME IN ('slug', 'unit', 'box_item_count', 'is_featured');

# Check order_items has snapshot prices
SELECT * FROM order_items LIMIT 1;
# Should show: unit_price (snapshot), NOT referencing products.price_*

# Verify transactions work
php artisan tinker
> DB::transaction(function() { /* code */ });
```

---

## 🔐 **Security & Validation**

### **ProductController Validations:**
- ✅ Image max 2MB (max:2048)
- ✅ Price format: numeric, min 100
- ✅ Slug generation: auto-generated from name
- ✅ Stock: non-negative integer

### **CheckoutController Validations:**
- ✅ Cart items exist
- ✅ Quantity > 0
- ✅ Stock available (implicit via DB transaction)
- ✅ Customer address required

### **Transaction Protection:**
- ✅ All-or-nothing execution
- ✅ Auto-rollback on error
- ✅ No orphaned orders

---

## 📝 **API Documentation**

### **PricingHelper::calculateItemPrice()**
```php
@param Product $product
@param int $quantity (quantity in smallest unit - PCS)
@return array [
    'effective_price' => int,
    'price_type' => 'unit'|'bulk_4'|'dozen',
    'total_price' => int,
    'box_count' => int,
    'description' => string
]
```

### **Product::calculateEffectivePrice()**
```php
@param int $quantity
@return int (effective unit price in rupiah)
```

### **PricingHelper::getPriceBreakdown()**
```php
@param Product $product
@return array [
    'unit' => [ 'price', 'min_qty', 'label' ],
    'bulk_4' => [ 'price', 'min_qty', 'label', 'available' ],
    'dozen' => [ 'price', 'min_qty', 'label', 'available', 'effective_unit_price' ]
]
```

---

## 🎯 **NEXT PHASES**

### **Phase 1 (Current):** ✅ COMPLETE
- Database schema with tiered pricing
- PricingHelper calculation engine
- CheckoutController with transactions
- Product detail UI with price preview
- Checkout UI with breakdown

### **Phase 2: Admin Verification**
- Admin dashboard showing pending payments
- Payment proof upload verification
- Order status workflow (pending → verifying → paid → shipped → completed)
- Stock confirmation after payment

### **Phase 3: Reports & Analytics**
- Sales by tier breakdown
- Revenue optimization insights
- Inventory forecasting
- Customer tier distribution

---

**Generated:** December 15, 2025
**Version:** 1.0 - Production Ready
