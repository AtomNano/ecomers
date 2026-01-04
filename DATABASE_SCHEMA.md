# 🗄️ Database Schema - Grosir Berkat Ibu

Dokumentasi lengkap struktur database dan relationship.

---

## 📊 Entity Relationship Diagram (ERD)

```
┌─────────────┐          ┌──────────────┐
│   USERS     │          │   CATEGORIES │
├─────────────┤          ├──────────────┤
│ id (PK)     │          │ id (PK)      │
│ name        │          │ name         │
│ email       │          │ description  │
│ role        │◄─────────│ image        │
│ phone       │          │ timestamps   │
│ province    │          └──────────────┘
│ city        │                 ▲
│ district    │                 │ has many
│ address     │                 │
│ password    │          ┌──────────────┐
│ timestamps  │          │   PRODUCTS   │
└─────────────┘          ├──────────────┤
       │                 │ id (PK)      │
       │ has many        │ name         │
       ├──────────────┬──│ description  │
       │              │  │ category_id  │
       │              │  │ image        │
       │              │  │ price_unit   │
       │              │  │ price_bulk_4 │
       │              │  │ price_dozen  │
       │              │  │ stock        │
       │              │  │ min_stock    │
       │              │  │ timestamps   │
       │              │  └──────────────┘
       │              │        ▲
       │              │        │
   ┌───┴──────┬───────┘   ┌────┴───────┐
   │          │           │            │
┌──▼──┐  ┌────▼───┐  ┌────▼────┐  ┌───▼──────┐
│CARTS│  │ ORDERS │  │ORDER     │  │PRICE     │
│     │  │        │  │ITEMS     │  │TIERS     │
└─────┘  └────┬───┘  └──────────┘  └──────────┘
              │
              │ has one
              ▼
         ┌─────────────┐
         │  PAYMENTS   │
         └─────────────┘
```

---

## 📝 Table Specifications

### 1. USERS Table
**Tujuan:** Menyimpan data user dengan 3 role (customer, admin, owner)

```sql
CREATE TABLE users (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    role ENUM('customer', 'admin', 'owner') DEFAULT 'customer',
    phone VARCHAR(20),
    province VARCHAR(100),
    city VARCHAR(100),
    district VARCHAR(100),
    address TEXT,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_role (role),
    INDEX idx_email (email)
);
```

**Field Details:**
| Field | Type | Nullable | Description |
|-------|------|----------|-------------|
| id | BIGINT | NO | Primary key, auto increment |
| name | VARCHAR(255) | NO | Full name pengguna |
| email | VARCHAR(255) | NO | Email unique untuk login |
| role | ENUM | NO | customer/admin/owner, default='customer' |
| phone | VARCHAR(20) | YES | Nomor telepon/WhatsApp |
| province | VARCHAR(100) | YES | Provinsi asal |
| city | VARCHAR(100) | YES | Kota/Kabupaten asal |
| district | VARCHAR(100) | YES | Kecamatan asal |
| address | TEXT | YES | Alamat lengkap |
| password | VARCHAR(255) | NO | Password terenkripsi (bcrypt) |
| email_verified_at | TIMESTAMP | YES | Tanggal verifikasi email |
| remember_token | VARCHAR(100) | YES | Token untuk remember me |
| created_at | TIMESTAMP | NO | Waktu pembuatan record |
| updated_at | TIMESTAMP | NO | Waktu update terakhir |

**Relationships:**
- `hasMany()` → Orders
- `hasMany()` → Carts

---

### 2. CATEGORIES Table
**Tujuan:** Menyimpan kategori produk

```sql
CREATE TABLE categories (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_name (name)
);
```

**Relationships:**
- `hasMany()` → Products

---

### 3. PRODUCTS Table
**Tujuan:** Menyimpan data produk dengan harga bertingkat

```sql
CREATE TABLE products (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    category_id BIGINT UNSIGNED NOT NULL,
    image VARCHAR(255),
    price_unit DECIMAL(12, 2) NOT NULL COMMENT 'Harga per satuan (1 pcs)',
    price_bulk_4 DECIMAL(12, 2) COMMENT 'Harga untuk pembelian > 4 pcs',
    price_dozen DECIMAL(12, 2) COMMENT 'Harga per lusin/dus',
    stock INT DEFAULT 0,
    min_stock INT DEFAULT 5,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
    INDEX idx_category (category_id),
    INDEX idx_stock (stock)
);
```

**Field Details:**
| Field | Type | Description |
|-------|------|-------------|
| price_unit | DECIMAL(12,2) | Harga untuk pembelian 1-3 pcs |
| price_bulk_4 | DECIMAL(12,2) | Harga untuk pembelian > 4 pcs (optional) |
| price_dozen | DECIMAL(12,2) | Harga untuk pembelian per lusin/karton (optional) |
| stock | INT | Jumlah stok saat ini |
| min_stock | INT | Minimum stok sebelum notifikasi |

**Relationships:**
- `belongsTo()` → Category
- `hasMany()` → Carts
- `hasMany()` → OrderItems
- `hasMany()` → PriceTiers

---

### 4. CARTS Table
**Tujuan:** Menyimpan item keranjang belanja customer

```sql
CREATE TABLE carts (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    product_id BIGINT UNSIGNED NOT NULL,
    quantity INT NOT NULL,
    price_type ENUM('unit', 'bulk_4', 'dozen') DEFAULT 'unit',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY unique_cart_item (user_id, product_id, price_type),
    INDEX idx_user (user_id)
);
```

**Field Details:**
| Field | Description |
|-------|-------------|
| price_type | Jenis harga yang dipilih (unit/bulk_4/dozen) |

**Relationships:**
- `belongsTo()` → User
- `belongsTo()` → Product

---

### 5. ORDERS Table
**Tujuan:** Menyimpan data pesanan customer

```sql
CREATE TABLE orders (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    total_amount DECIMAL(12, 2) NOT NULL,
    shipping_cost DECIMAL(12, 2) DEFAULT 0,
    shipping_method ENUM('gosend', 'pickup', 'custom') DEFAULT 'gosend',
    status ENUM('pending', 'payment_verified', 'shipped', 'completed', 'cancelled') DEFAULT 'pending',
    customer_name VARCHAR(255) NOT NULL,
    customer_phone VARCHAR(20) NOT NULL,
    customer_address TEXT NOT NULL,
    shipped_at TIMESTAMP NULL,
    completed_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user (user_id),
    INDEX idx_status (status),
    INDEX idx_created (created_at)
);
```

**Status Flow:**
```
pending → payment_verified → shipped → completed
                          ↘ cancelled
```

**Relationships:**
- `belongsTo()` → User
- `hasMany()` → OrderItems
- `hasOne()` → Payment

---

### 6. ORDER_ITEMS Table
**Tujuan:** Menyimpan item detail dalam pesanan

```sql
CREATE TABLE order_items (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    order_id BIGINT UNSIGNED NOT NULL,
    product_id BIGINT UNSIGNED NOT NULL,
    quantity INT NOT NULL,
    price_type ENUM('unit', 'bulk_4', 'dozen') DEFAULT 'unit',
    unit_price DECIMAL(12, 2) NOT NULL,
    subtotal DECIMAL(12, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE RESTRICT,
    INDEX idx_order (order_id),
    INDEX idx_product (product_id)
);
```

**Relationships:**
- `belongsTo()` → Order
- `belongsTo()` → Product

---

### 7. PAYMENTS Table
**Tujuan:** Menyimpan data pembayaran dan bukti transaksi

```sql
CREATE TABLE payments (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    order_id BIGINT UNSIGNED NOT NULL UNIQUE,
    payment_method ENUM('transfer', 'qris') DEFAULT 'transfer',
    status ENUM('pending', 'verified', 'rejected') DEFAULT 'pending',
    proof_image VARCHAR(255),
    amount DECIMAL(12, 2) NOT NULL,
    paid_at TIMESTAMP NULL,
    verified_at TIMESTAMP NULL,
    verification_notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    INDEX idx_order (order_id),
    INDEX idx_status (status)
);
```

**Payment Method:**
- `transfer` - Transfer ke rekening bank
- `qris` - Scan QRIS

**Status:**
- `pending` - Menunggu bukti pembayaran & verifikasi
- `verified` - Pembayaran terverifikasi
- `rejected` - Pembayaran ditolak

**Relationships:**
- `belongsTo()` → Order

---

### 8. PRICE_TIERS Table
**Tujuan:** Menyimpan tier harga fleksibel untuk produk

```sql
CREATE TABLE price_tiers (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    product_id BIGINT UNSIGNED NOT NULL,
    tier_name VARCHAR(100) NOT NULL,
    min_quantity INT DEFAULT 1,
    max_quantity INT NULL,
    price DECIMAL(12, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    INDEX idx_product (product_id)
);
```

**Contoh Data:**
| product_id | tier_name | min_qty | max_qty | price |
|------------|-----------|---------|---------|-------|
| 1 | unit | 1 | 3 | 5000 |
| 1 | bulk_4 | 4 | 11 | 4500 |
| 1 | dozen | 12 | NULL | 4000 |

**Relationships:**
- `belongsTo()` → Product

---

### 9. STORE_SETTINGS Table
**Tujuan:** Menyimpan informasi toko (konfigurasi)

```sql
CREATE TABLE store_settings (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    store_name VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    province VARCHAR(100) NOT NULL,
    city VARCHAR(100) NOT NULL,
    district VARCHAR(100) NOT NULL,
    maps_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

**Contoh:**
```php
StoreSetting::first()->update([
    'store_name' => 'Grosir Berkat Ibu',
    'phone' => '08123456789',
    'address' => 'Jl. Contoh No. 123',
    'province' => 'Jawa Barat',
    'city' => 'Bandung',
    'district' => 'Cihampelas',
    'maps_url' => 'https://maps.google.com/...'
]);
```

---

## 🔗 Relationship Summary

| Model | Relationship | Target | Type |
|-------|--------------|--------|------|
| User | orders | Order | 1:many |
| User | carts | Cart | 1:many |
| Category | products | Product | 1:many |
| Product | category | Category | many:1 |
| Product | carts | Cart | 1:many |
| Product | orderItems | OrderItem | 1:many |
| Product | priceTiers | PriceTier | 1:many |
| Cart | user | User | many:1 |
| Cart | product | Product | many:1 |
| Order | user | User | many:1 |
| Order | items | OrderItem | 1:many |
| Order | payment | Payment | 1:1 |
| OrderItem | order | Order | many:1 |
| OrderItem | product | Product | many:1 |
| Payment | order | Order | many:1 |
| PriceTier | product | Product | many:1 |

---

## 📈 Database Queries Examples

### Get Product with All Pricing Info
```php
$product = Product::with('category', 'priceTiers')->find(1);
```

### Get Order with Complete Details
```php
$order = Order::with(['user', 'items.product', 'payment'])->find(1);
```

### Get User Cart with Products
```php
$carts = User::find(1)->carts()->with('product')->get();
```

### Calculate Cart Total
```php
$total = Cart::where('user_id', 1)
    ->with('product')
    ->get()
    ->sum(function($cart) {
        return $cart->quantity * $cart->getUnitPriceAttribute();
    });
```

### Get Monthly Revenue
```php
$revenue = Order::where('status', 'completed')
    ->whereMonth('created_at', 12)
    ->whereYear('created_at', 2025)
    ->sum('total_amount');
```

### Get Best Selling Products
```php
$bestSellers = Product::select('products.*', 
        DB::raw('SUM(order_items.quantity) as sold'))
    ->join('order_items', 'products.id', '=', 'order_items.product_id')
    ->groupBy('products.id')
    ->orderByDesc('sold')
    ->limit(10)
    ->get();
```

---

## 🔐 Indexing Strategy

**Indexed Columns:**
- `users.role` - Untuk filtering by role
- `users.email` - Untuk login & unique check
- `products.category_id` - Untuk join dengan categories
- `products.stock` - Untuk filtering produk dengan stok
- `carts.user_id` - Untuk get user carts
- `orders.user_id` - Untuk get user orders
- `orders.status` - Untuk filtering status
- `orders.created_at` - Untuk sorting & date filtering
- `payments.order_id` - Untuk unique constraint
- `payments.status` - Untuk filtering payment status
- `order_items.order_id` - Untuk get order items
- `order_items.product_id` - Untuk product details
- `price_tiers.product_id` - Untuk get price tiers

---

## 📊 Database Growth Estimation

**Assuming 1000 customers & 100 products:**

| Table | Avg Records | Size |
|-------|-------------|------|
| users | 1100 | ~500 KB |
| categories | 10 | ~5 KB |
| products | 100 | ~50 KB |
| carts | 500 | ~50 KB |
| orders | 5000 | ~2 MB |
| order_items | 15000 | ~2 MB |
| payments | 5000 | ~2 MB |
| price_tiers | 300 | ~50 KB |
| **TOTAL** | **~27,000** | **~7 MB** |

---

## 🔄 Transaction Flow in Database

### Customer Purchase Flow
```
1. Add to Cart
   ↓
   INSERT INTO carts (user_id, product_id, quantity, price_type)
   
2. Checkout
   ↓
   INSERT INTO orders (user_id, total_amount, ...)
   INSERT INTO order_items (order_id, product_id, ...)
   UPDATE products SET stock = stock - quantity
   INSERT INTO payments (order_id, payment_method, ...)
   DELETE FROM carts WHERE user_id = X
   
3. Upload Payment Proof
   ↓
   UPDATE payments SET proof_image = X, paid_at = NOW()
   
4. Admin Verify Payment
   ↓
   UPDATE payments SET status = 'verified', verified_at = NOW()
   UPDATE orders SET status = 'payment_verified'
   → Send WhatsApp to customer
   
5. Mark as Shipped
   ↓
   UPDATE orders SET status = 'shipped', shipped_at = NOW()
   
6. Complete Order
   ↓
   UPDATE orders SET status = 'completed', completed_at = NOW()
```

---

**Last Updated:** December 15, 2025  
**Database Version:** 1.0.0
