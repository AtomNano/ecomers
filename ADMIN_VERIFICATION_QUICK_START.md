# ⚡ Admin Verification System - Quick Start

## 🚀 Go Live (5 Menit)

### 1. Ensure Server Running
```bash
php artisan serve
```

### 2. Access Admin Orders Page
```
http://127.0.0.1:8000/admin/orders
```

You should see:
- ✅ List of orders with invoice numbers
- ✅ "Verifikasi" button di setiap order
- ✅ Status badges (waiting_verification, paid, rejected, dll)

### 3. Click "Verifikasi" on Any Order

Expected Screen:
```
┌─────────────────────────────────────────────┐
│  LEFT: Foto Bukti Bayar (Zoomable)         │
│  RIGHT: Rincian Belanja + Tombol Approve   │
└─────────────────────────────────────────────┘
```

### 4. Admin Workflow

**Option A: APPROVE Payment**
1. Lihat foto bukti → zoom jika perlu
2. Cocokkan total dengan nominal di bukti
3. Lihat stok check: semua item ada stok?
4. Click "✅ Terima & Proses"
5. Confirm dialog keluar
6. ✅ Success! Stok berkurang, WA tab buka

**Option B: REJECT Payment**
1. Click "❌ Tolak Bukti"
2. Modal keluar
3. Type alasan: "Bukti buram", "Nominal kurang", dll
4. Click "Kirim Penolakan"
5. ✅ Order rejected, WA notif dikirim

---

## ✅ Testing Workflow (10 Menit)

### Scenario: Customer Sudah Transfer, Admin Verify

#### Pre-Condition
- Ada order dengan status `waiting_verification`
- Ada `payment_proof` file (bukti bayar)
- Stok mencukupi

#### Test Steps
1. **Open verification page**
   - Navigate: `/admin/orders/{id}/verify`
   - Verify: Image muncul, info customer terlihat

2. **Check stock**
   - Lihat "📦 Cek Stok Barang"
   - Semua item harus "✅ Cukup"

3. **Approve payment**
   - Click "✅ Terima & Proses"
   - Confirm dialog
   - ✅ Redirect dengan success message
   - ✅ WA tab buka (jika device punya WA)

4. **Verify database**
   ```sql
   -- Check order status changed
   SELECT status FROM orders WHERE id = 1;
   -- Result: paid ✅
   
   -- Check stock decreased
   SELECT stock FROM products WHERE id = 1;
   -- Result: (original_stock - quantity) ✅
   ```

5. **Test reject (optional)**
   - Go back to order list
   - Open another waiting order
   - Click "❌ Tolak Bukti"
   - Fill reason
   - ✅ Confirm rejected
   - Check: stok tidak berkurang ✅

---

## 📁 Files Modified

| File | Action | Status |
|------|--------|--------|
| `app/Http/Controllers/Admin/AdminOrderController.php` | Created | ✅ |
| `resources/views/admin/orders/verify.blade.php` | Created | ✅ |
| `resources/views/admin/orders/index.blade.php` | Updated | ✅ |
| `routes/web.php` | Updated (added routes) | ✅ |

---

## 🔑 Key Features

### 1. Split-Screen UI
- Admin tidak perlu bolak-balik tab
- Lihat bukti & data bersamaan
- Zoom foto tanpa keluar dari page

### 2. Stock Management
- Stok hanya berkurang saat approval
- Prevent ghosting orders
- Real-time availability check

### 3. WhatsApp Integration
- Auto WA link generation
- Pre-filled message
- Tab buka otomatis (1.5 detik delay)

### 4. Error Handling
- DB transaction → no partial updates
- Row locking → prevent double approval
- Validation → all inputs checked

---

## ⚠️ Important Notes

### Stok Deduction Timing
```
❌ TIDAK saat checkout (bisa jadi ghosting)
✅ SAAl admin approve (pembayaran terbukti)
```

### Overselling Prevention
- Stok dicek sebelum decrement
- Jika stok kurang → error, order tidak diproses
- Row lock mencegah race condition

### Admin Responsibilities
1. **Verify bukti sebelum approve**
   - Zoom foto jika buram
   - Cocokkan nominal
   - Cek tanggal transfer

2. **Hati-hati saat approve**
   - Stok akan berkurang PERMANEN
   - Tidak bisa undo dari UI (harus DB manual)
   - Confirm dialog ingatkan tentang ini

3. **Tolak jika ragu**
   - Better safe than sorry
   - Beri alasan jelas
   - Customer akan hubungi kembali

---

## 🐛 Troubleshooting

### Issue: "Order ini sudah diproses sebelumnya"
**Cause:** Admin sudah approve/reject order ini sebelumnya
**Solution:** Normal! Cegah double approval. Buka order lain.

### Issue: "Stok untuk X tidak cukup! Sisa: 2, Diminta: 5"
**Cause:** Overselling (lihat penjelasan di atas)
**Solution:** Reject order ini, contact customer untuk revisi quantity

### Issue: Foto bukti tidak muncul
**Cause:** File tidak ada / path salah
**Solution:** Check `storage/app/public/` folder

### Issue: WA tab tidak buka
**Cause:** Nomor HP format salah / browser block popup
**Solution:** Check phone format, allow popup, atau klik manual

---

## 📞 Quick Reference

### Database Queries (Debugging)

**List pending orders:**
```sql
SELECT id, invoice_number, user_id, status FROM orders 
WHERE status = 'waiting_verification';
```

**Check product stock:**
```sql
SELECT id, name, stock FROM products WHERE id = 1;
```

**See approval history:**
```sql
SELECT id, order_id, status, admin_note, created_at 
FROM orders WHERE status IN ('paid', 'rejected') 
ORDER BY updated_at DESC LIMIT 10;
```

### Route Mapping

| Route | Method | URL | Purpose |
|-------|--------|-----|---------|
| admin.orders.index | GET | /admin/orders | List all orders |
| admin.orders.show | GET | /admin/orders/{id}/verify | Verification page |
| admin.orders.approve | POST | /admin/orders/{id}/approve | Process approval |
| admin.orders.reject | POST | /admin/orders/{id}/reject | Process rejection |

---

## ✨ Success Indicators

After successful implementation, you should see:

✅ Admin can view payment proof  
✅ Admin can approve & stok berkurang  
✅ Admin can reject & WA notif dikirim  
✅ No stok overselling  
✅ No double approval possible  
✅ All data persisted correctly  

---

**Status:** Ready for Production ✅  
**Tested:** All core features ✅  
**Documentation:** Complete ✅
