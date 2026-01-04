# ✅ INTEGRATION GUIDE - Connect Checkout to Payment

## Quick Setup

### **1. Update Checkout Success Redirect**

In `app/Http/Controllers/Customer/CheckoutController.php`, modify the `store()` method to redirect to payment page instead of generic success:

```php
// CURRENT (OLD):
return redirect()->route('customer.checkout.index')
    ->with('success', 'Order berhasil dibuat');

// NEW (UPDATED):
return redirect()->route('orders.payment', $order->invoice_number);
```

**Full context in `store()` method:**
```php
public function store(Request $request)
{
    // ... validation code ...
    
    $order = DB::transaction(function () {
        // ... 6-step checkout process ...
    }, 3);
    
    // Redirect to payment page
    return redirect()->route('orders.payment', $order->invoice_number)
        ->with('success', 'Order berhasil dibuat. Silakan selesaikan pembayaran.');
}
```

### **2. Add Payment Button to Checkout View**

If you want customers to see a button to complete payment, update the checkout success message:

In `resources/views/customer/checkout.blade.php` (after form submission):

```blade
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
        <a href="{{ route('orders.payment', $order->invoice_number) }}" class="btn btn-primary">
            Lanjut ke Pembayaran
        </a>
    </div>
@endif
```

### **3. Update Order Show View (Optional)**

If you have an order detail page (`resources/views/customer/orders/show.blade.php`), add a button to payment:

```blade
@if($order->status === 'pending' && !$order->payment_proof)
    <a href="{{ route('orders.payment', $order->invoice_number) }}" class="btn btn-primary btn-lg">
        <i class="fas fa-credit-card"></i> Selesaikan Pembayaran
    </a>
@endif
```

---

## 📋 Complete Checkout Flow Now

```
1. Customer adds items to cart
   ↓
2. Click "Checkout"
   ↓
3. Fill address & shipping info
   ↓
4. Review order total
   ↓
5. Click "Buat Pesanan"
   ↓
   [CheckoutController@store]
   - Calculate prices
   - Create order
   - Create order items
   - Deduct stock
   - Clear cart
   ↓
6. REDIRECT TO PAYMENT PAGE
   ↓
   [OrderController@showPayment]
   ↓
7. See total + copy bank info + upload proof
   ↓
8. REDIRECT TO SUCCESS PAGE
   ↓
   [OrderController@showSuccess]
   ↓
9. See confirmation + WhatsApp link
```

---

## 🔗 Route Reference

| Action | Route | Method |
|--------|-------|--------|
| Show Payment Form | `/orders/{invoice}/payment` | GET |
| Upload Proof | `/orders/{id}/upload-proof` | POST |
| Show Success | `/orders/{invoice}/success` | GET |

---

## 🎨 Optional Button Placements

### **A. Checkout Success (In CheckoutController)**
```php
// Option: Pass order to success view
return redirect()->route('orders.payment', $order->invoice_number);
```

### **B. Customer Dashboard (In HomeController)**
Add payment button next to pending orders:
```blade
@foreach($orders as $order)
    <tr>
        <td>{{ $order->invoice_number }}</td>
        <td>{{ $order->total_amount }}</td>
        <td>
            @if($order->status === 'pending')
                <a href="{{ route('orders.payment', $order->invoice_number) }}" class="btn btn-sm btn-primary">
                    Bayar Sekarang
                </a>
            @endif
        </td>
    </tr>
@endforeach
```

### **C. Customer Orders History**
```blade
@if($order->status === 'pending' && $order->payment_proof === null)
    <a href="{{ route('orders.payment', $order->invoice_number) }}" class="text-primary">
        <i class="fas fa-arrow-right"></i> Lanjutkan Pembayaran
    </a>
@endif
```

---

## ✅ Testing Payment Flow

1. **Login as customer**
   ```
   Email: budi@example.com
   Password: password123
   ```

2. **Add products to cart**
   - Browse products → click Add to Cart

3. **Checkout**
   - Go to Cart → Checkout
   - Fill address
   - Select shipping & payment method
   - Click "Buat Pesanan"

4. **Should redirect to payment page**
   - URL: `http://127.0.0.1:8000/orders/INV/2025/12/XXXX/payment`

5. **On payment page**
   - ✅ See total amount
   - ✅ Copy bank account number
   - ✅ Upload proof image
   - ✅ Click "Kirim Bukti Pembayaran"

6. **Should redirect to success page**
   - URL: `http://127.0.0.1:8000/orders/INV/2025/12/XXXX/success`
   - ✅ See success message
   - ✅ See status timeline
   - ✅ Click WhatsApp link

7. **Check database**
   ```sql
   SELECT invoice_number, status, payment_proof 
   FROM orders 
   WHERE status = 'waiting_verification';
   ```
   Should show:
   - ✅ invoice_number filled
   - ✅ status = 'waiting_verification'
   - ✅ payment_proof = path to image

8. **Login as admin**
   - Go to `/admin/orders`
   - ✅ See "waiting_verification" order
   - ✅ Can view payment_proof image
   - ✅ Click "Verify" button

---

## 🐛 Troubleshooting

| Issue | Solution |
|-------|----------|
| Payment page shows 404 | Check route name: `orders.payment` (not `customer.payment`) |
| Can't upload image | Check `storage/app/public` exists and is writable |
| Image not visible after upload | Run: `php artisan storage:link` |
| WhatsApp link not working | Check admin phone number in success.blade.php (hardcoded in template) |
| Order status not changing | Check `OrderController@uploadProof` runs without errors |
| File size validation fails | Check mime types - JPEG, PNG, JPG, WebP only. Max 2MB. |

---

## 🎯 Configuration

### **Admin WhatsApp Number** (in `resources/views/orders/success.blade.php`)

Currently hardcoded:
```php
$adminPhone = '6281234567890';
```

**To make dynamic**, update to pull from database:

```php
// Get from store_settings table
$storeSetting = \App\Models\StoreSetting::first();
$adminPhone = $storeSetting->admin_whatsapp ?? '6281234567890';
```

Then update success.blade.php:
```php
@php
    $storeSetting = \App\Models\StoreSetting::first();
    $adminPhone = $storeSetting->admin_whatsapp ?? '6281234567890';
    $message = "...";
    $waLink = "https://wa.me/" . str_replace('+', '', $adminPhone) . "?text=" . urlencode($message);
@endphp
```

---

## 📝 Database Check

After uploading payment proof, database should show:

```sql
mysql> SELECT id, invoice_number, status, payment_proof FROM orders WHERE status = 'waiting_verification';
+----+------------------+---------------------+---------------------------------+
| id | invoice_number   | status              | payment_proof                   |
+----+------------------+---------------------+---------------------------------+
| 1  | INV/2025/12/0001 | waiting_verification| payment_proofs/xxx123.jpg       |
+----+------------------+---------------------+---------------------------------+
```

---

## ✨ That's It!

Your payment flow is now complete. Customers can:
1. ✅ Complete checkout
2. ✅ See total amount
3. ✅ Copy bank info with 1 click
4. ✅ Upload payment proof
5. ✅ Get instant confirmation
6. ✅ Contact admin via WhatsApp with auto-generated message

All without leaving the app. Zero friction. Maximum confidence.

---

**Ready to test?** Start server and login!
```bash
php artisan serve
# Visit http://127.0.0.1:8000/login
```
