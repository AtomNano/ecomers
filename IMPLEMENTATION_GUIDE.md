# 📚 Implementation Guide - Grosir Berkat Ibu

Dokumentasi lengkap untuk implementasi semua fitur e-commerce.

---

## 🎯 Checklist Implementasi

### 1. Authentication System (AuthController, RegisterController, ForgotPasswordController)

#### AuthController - Login & Logout
```php
// app/Http/Controllers/Auth/AuthController.php

public function showLogin()
{
    // Tampilkan form login
    return view('auth.login');
}

public function login(Request $request)
{
    // Validasi input
    $validated = $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6'
    ]);
    
    // Cek kredensial
    if (Auth::attempt($validated)) {
        $user = Auth::user();
        
        // Redirect berdasarkan role
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'owner') {
            return redirect()->route('owner.dashboard');
        } else {
            return redirect()->route('customer.home');
        }
    }
    
    return back()->with('error', 'Email atau password salah');
}

public function logout()
{
    Auth::logout();
    return redirect('/')->with('success', 'Berhasil logout');
}
```

#### RegisterController - Registrasi User
```php
// app/Http/Controllers/Auth/RegisterController.php

public function showRegister()
{
    return view('auth.register');
}

public function register(Request $request)
{
    // Validasi
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8|confirmed',
        'phone' => 'required|string',
        'province' => 'required|string',
        'city' => 'required|string',
        'district' => 'required|string',
        'address' => 'required|string',
    ]);
    
    // Create user
    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'phone' => $validated['phone'],
        'province' => $validated['province'],
        'city' => $validated['city'],
        'district' => $validated['district'],
        'address' => $validated['address'],
        'role' => 'customer', // Default role
        'password' => bcrypt($validated['password']),
    ]);
    
    // Auto login setelah register
    Auth::login($user);
    
    return redirect()->route('customer.home')->with('success', 'Registrasi berhasil!');
}
```

#### ForgotPasswordController - Reset Password
```php
// app/Http/Controllers/Auth/ForgotPasswordController.php

public function showForm()
{
    return view('auth.forgot-password');
}

public function sendReset(Request $request)
{
    $request->validate(['email' => 'required|email|exists:users']);
    
    // Send password reset link
    // Implementasi bisa pakai Mail atau service lain
    
    return back()->with('success', 'Link reset sudah dikirim ke email');
}

public function showReset($token)
{
    return view('auth.reset-password', ['token' => $token]);
}

public function resetPassword(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);
    
    // Update password user
    $user = User::where('email', $request->email)->first();
    if ($user) {
        $user->update(['password' => bcrypt($request->password)]);
    }
    
    return redirect('/login')->with('success', 'Password berhasil direset');
}
```

---

### 2. Customer Home & Products

#### Customer HomeController
```php
// app/Http/Controllers/Customer/HomeController.php

public function index()
{
    // Home page untuk guest & customer
    $latestProducts = Product::latest()->limit(6)->get();
    $bestSellingProducts = Product::orderBy('sold', 'desc')->limit(6)->get();
    $categories = Category::all();
    $storeSetting = StoreSetting::first();
    
    return view('customer.home', compact(
        'latestProducts',
        'bestSellingProducts', 
        'categories',
        'storeSetting'
    ));
}

public function about()
{
    $storeSetting = StoreSetting::first();
    return view('customer.about', compact('storeSetting'));
}

public function dashboard()
{
    // Dashboard untuk customer yang sudah login
    return view('customer.dashboard');
}

public function orders()
{
    $orders = auth()->user()->orders()->latest()->paginate(10);
    return view('customer.orders', compact('orders'));
}
```

#### Customer ProductController
```php
// app/Http/Controllers/Customer/ProductController.php

public function index()
{
    $products = Product::with('category')->paginate(12);
    $categories = Category::all();
    
    // Jika ada filter kategori
    if (request('category')) {
        $products = Product::where('category_id', request('category'))->paginate(12);
    }
    
    return view('customer.products.index', compact('products', 'categories'));
}

public function show($id)
{
    $product = Product::with('category')->findOrFail($id);
    $relatedProducts = Product::where('category_id', $product->category_id)
                              ->where('id', '!=', $id)
                              ->limit(4)
                              ->get();
    
    return view('customer.products.show', compact('product', 'relatedProducts'));
}
```

---

### 3. Shopping Cart

#### CartController
```php
// app/Http/Controllers/Customer/CartController.php

public function add(Request $request)
{
    $validated = $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
        'price_type' => 'required|in:unit,bulk_4,dozen'
    ]);
    
    $userId = auth()->id();
    $productId = $validated['product_id'];
    
    // Cek apakah sudah ada di keranjang
    $cartItem = Cart::where('user_id', $userId)
                   ->where('product_id', $productId)
                   ->where('price_type', $validated['price_type'])
                   ->first();
    
    if ($cartItem) {
        // Update quantity
        $cartItem->increment('quantity', $validated['quantity']);
    } else {
        // Tambah item baru
        Cart::create([
            'user_id' => $userId,
            'product_id' => $productId,
            'quantity' => $validated['quantity'],
            'price_type' => $validated['price_type']
        ]);
    }
    
    return back()->with('success', 'Produk ditambahkan ke keranjang');
}

public function index()
{
    $carts = auth()->user()->carts()->with('product')->get();
    $total = $carts->sum(function($cart) {
        return $cart->quantity * $cart->getUnitPriceAttribute();
    });
    
    return view('customer.cart', compact('carts', 'total'));
}

public function update(Request $request, $id)
{
    $cart = Cart::findOrFail($id);
    $cart->update(['quantity' => $request->quantity]);
    
    return back()->with('success', 'Keranjang diupdate');
}

public function remove($id)
{
    Cart::findOrFail($id)->delete();
    return back()->with('success', 'Item dihapus dari keranjang');
}

public function clear()
{
    auth()->user()->carts()->delete();
    return back()->with('success', 'Keranjang dikosongkan');
}
```

---

### 4. Checkout & Orders

#### CheckoutController
```php
// app/Http/Controllers/Customer/CheckoutController.php

public function index()
{
    $carts = auth()->user()->carts()->with('product')->get();
    
    if ($carts->isEmpty()) {
        return redirect()->route('customer.products')
                        ->with('error', 'Keranjang kosong');
    }
    
    // Hitung subtotal
    $subtotal = $carts->sum(function($cart) {
        return $cart->quantity * $cart->getUnitPriceAttribute();
    });
    
    $user = auth()->user();
    
    return view('customer.checkout', compact('carts', 'subtotal', 'user'));
}

public function store(Request $request)
{
    $validated = $request->validate([
        'shipping_method' => 'required|in:gosend,pickup,custom',
        'payment_method' => 'required|in:transfer,qris',
        'customer_name' => 'required|string',
        'customer_phone' => 'required|string',
        'customer_address' => 'required|string',
    ]);
    
    $carts = auth()->user()->carts()->with('product')->get();
    
    // Hitung total
    $subtotal = $carts->sum(function($cart) {
        return $cart->quantity * $cart->getUnitPriceAttribute();
    });
    
    $shippingCost = 0;
    if ($validated['shipping_method'] === 'gosend') {
        // Hitung dari GoSend API
        $shippingCost = 10000; // Placeholder
    }
    
    $totalAmount = $subtotal + $shippingCost;
    
    // Create order
    $order = Order::create([
        'user_id' => auth()->id(),
        'total_amount' => $totalAmount,
        'shipping_cost' => $shippingCost,
        'shipping_method' => $validated['shipping_method'],
        'status' => 'pending',
        'customer_name' => $validated['customer_name'],
        'customer_phone' => $validated['customer_phone'],
        'customer_address' => $validated['customer_address'],
    ]);
    
    // Create order items
    foreach ($carts as $cart) {
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $cart->product_id,
            'quantity' => $cart->quantity,
            'price_type' => $cart->price_type,
            'unit_price' => $cart->getUnitPriceAttribute(),
            'subtotal' => $cart->quantity * $cart->getUnitPriceAttribute(),
        ]);
        
        // Update stok produk
        $cart->product->decrement('stock', $cart->quantity);
    }
    
    // Create payment
    Payment::create([
        'order_id' => $order->id,
        'payment_method' => $validated['payment_method'],
        'status' => 'pending',
        'amount' => $totalAmount,
    ]);
    
    // Clear cart
    auth()->user()->carts()->delete();
    
    return redirect()->route('payment.show', $order->id)
                   ->with('success', 'Pesanan berhasil dibuat');
}
```

---

### 5. Payment

#### PaymentController
```php
// app/Http/Controllers/Customer/PaymentController.php

public function show($orderId)
{
    $order = Order::with(['items.product', 'payment'])->findOrFail($orderId);
    
    // Ensure order belongs to user
    if ($order->user_id !== auth()->id()) {
        abort(403);
    }
    
    $payment = $order->payment;
    
    return view('customer.payment.show', compact('order', 'payment'));
}

public function uploadProof(Request $request, $orderId)
{
    $order = Order::with('payment')->findOrFail($orderId);
    
    if ($order->user_id !== auth()->id()) {
        abort(403);
    }
    
    $validated = $request->validate([
        'proof_image' => 'required|image|max:2048'
    ]);
    
    // Upload image
    $path = $request->file('proof_image')->store('payments', 'public');
    
    // Update payment
    $order->payment->update([
        'proof_image' => $path,
        'paid_at' => now(),
        'status' => 'pending'
    ]);
    
    return redirect()->route('payment.status', $order->id)
                   ->with('success', 'Bukti pembayaran berhasil dikirim');
}

public function status($orderId)
{
    $order = Order::with('payment')->findOrFail($orderId);
    
    if ($order->user_id !== auth()->id()) {
        abort(403);
    }
    
    return view('customer.payment.status', compact('order'));
}
```

---

### 6. Admin Dashboard & Products

#### Admin ProductController
```php
// app/Http/Controllers/Admin/ProductController.php

public function index()
{
    $products = Product::with('category')->paginate(10);
    return view('admin.products.index', compact('products'));
}

public function create()
{
    $categories = Category::all();
    return view('admin.products.create', compact('categories'));
}

public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string',
        'description' => 'nullable|string',
        'category_id' => 'required|exists:categories,id',
        'image' => 'nullable|image|max:2048',
        'price_unit' => 'required|numeric|min:0',
        'price_bulk_4' => 'nullable|numeric|min:0',
        'price_dozen' => 'nullable|numeric|min:0',
        'stock' => 'required|integer|min:0',
    ]);
    
    if ($request->hasFile('image')) {
        $validated['image'] = $request->file('image')->store('products', 'public');
    }
    
    Product::create($validated);
    
    return redirect()->route('admin.products.index')
                   ->with('success', 'Produk berhasil ditambahkan');
}

public function edit($id)
{
    $product = Product::findOrFail($id);
    $categories = Category::all();
    
    return view('admin.products.edit', compact('product', 'categories'));
}

public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);
    
    $validated = $request->validate([
        'name' => 'required|string',
        'description' => 'nullable|string',
        'category_id' => 'required|exists:categories,id',
        'image' => 'nullable|image|max:2048',
        'price_unit' => 'required|numeric|min:0',
        'price_bulk_4' => 'nullable|numeric|min:0',
        'price_dozen' => 'nullable|numeric|min:0',
        'stock' => 'required|integer|min:0',
    ]);
    
    if ($request->hasFile('image')) {
        $validated['image'] = $request->file('image')->store('products', 'public');
    }
    
    $product->update($validated);
    
    return redirect()->route('admin.products.index')
                   ->with('success', 'Produk berhasil diupdate');
}

public function destroy($id)
{
    Product::findOrFail($id)->delete();
    
    return back()->with('success', 'Produk berhasil dihapus');
}

public function updateStock(Request $request, $id)
{
    $product = Product::findOrFail($id);
    
    $validated = $request->validate([
        'stock' => 'required|integer|min:0'
    ]);
    
    $product->update(['stock' => $validated['stock']]);
    
    return back()->with('success', 'Stok berhasil diupdate');
}
```

---

### 7. Admin Orders & Verification

#### Admin OrderController
```php
// app/Http/Controllers/Admin/OrderController.php

public function index()
{
    $orders = Order::with('user', 'payment')
                   ->latest()
                   ->paginate(10);
    
    return view('admin.orders.index', compact('orders'));
}

public function show($id)
{
    $order = Order::with(['user', 'items.product', 'payment'])->findOrFail($id);
    
    return view('admin.orders.show', compact('order'));
}

public function verifyPayment(Request $request, $id)
{
    $order = Order::with('payment')->findOrFail($id);
    
    $order->payment->update([
        'status' => 'verified',
        'verified_at' => now(),
        'verification_notes' => $request->notes
    ]);
    
    $order->update(['status' => 'payment_verified']);
    
    // Send notification ke customer via WhatsApp
    // $this->sendWhatsAppNotification($order->user);
    
    return back()->with('success', 'Pembayaran berhasil diverifikasi');
}

public function rejectPayment(Request $request, $id)
{
    $order = Order::with('payment')->findOrFail($id);
    
    $order->payment->update([
        'status' => 'rejected',
        'verification_notes' => $request->notes
    ]);
    
    // Return stok produk
    foreach ($order->items as $item) {
        $item->product->increment('stock', $item->quantity);
    }
    
    $order->update(['status' => 'cancelled']);
    
    return back()->with('success', 'Pembayaran ditolak');
}

public function ship($id)
{
    $order = Order::findOrFail($id);
    $order->update(['status' => 'shipped', 'shipped_at' => now()]);
    
    return back()->with('success', 'Pesanan ditandai sebagai dikirim');
}
```

---

### 8. Admin Reports

#### Admin ReportController
```php
// app/Http/Controllers/Admin/ReportController.php

public function index()
{
    $totalRevenue = Order::where('status', 'completed')
                        ->sum('total_amount');
    
    $totalOrders = Order::count();
    
    // Chart data
    $monthlyRevenue = Order::where('status', 'completed')
                          ->selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
                          ->groupBy('month')
                          ->get();
    
    $weeklyRevenue = Order::where('status', 'completed')
                         ->selectRaw('WEEK(created_at) as week, SUM(total_amount) as total')
                         ->groupBy('week')
                         ->get();
    
    return view('admin.reports.index', compact(
        'totalRevenue',
        'totalOrders',
        'monthlyRevenue',
        'weeklyRevenue'
    ));
}

public function export()
{
    // Export ke CSV/Excel
    // Implementasi menggunakan Laravel Excel atau library sejenis
}
```

---

### 9. Owner Customer Management

#### Owner CustomerController
```php
// app/Http/Controllers/Owner/CustomerController.php

public function index()
{
    $customers = User::where('role', 'customer')
                    ->paginate(10);
    
    return view('owner.customers.index', compact('customers'));
}

public function show($id)
{
    $customer = User::findOrFail($id);
    $orders = $customer->orders()->latest()->get();
    
    return view('owner.customers.show', compact('customer', 'orders'));
}

public function create()
{
    return view('owner.customers.create');
}

public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:users',
        'phone' => 'required|string',
        'province' => 'required|string',
        'city' => 'required|string',
        'district' => 'required|string',
        'address' => 'required|string',
        'password' => 'required|min:8|confirmed',
    ]);
    
    $validated['role'] = 'customer';
    $validated['password'] = bcrypt($validated['password']);
    
    User::create($validated);
    
    return redirect()->route('owner.customers.index')
                   ->with('success', 'Customer berhasil ditambahkan');
}

public function edit($id)
{
    $customer = User::findOrFail($id);
    return view('owner.customers.edit', compact('customer'));
}

public function update(Request $request, $id)
{
    $customer = User::findOrFail($id);
    
    $validated = $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:users,email,' . $id,
        'phone' => 'required|string',
        'province' => 'required|string',
        'city' => 'required|string',
        'district' => 'required|string',
        'address' => 'required|string',
    ]);
    
    $customer->update($validated);
    
    return redirect()->route('owner.customers.index')
                   ->with('success', 'Customer berhasil diupdate');
}

public function destroy($id)
{
    User::findOrFail($id)->delete();
    
    return back()->with('success', 'Customer berhasil dihapus');
}
```

---

## 📝 Next Steps

1. **Implementasi Views (Blade Templates)**
   - Buat folder `resources/views` dengan struktur seperti di atas
   - Buat base layout dengan navbar & footer
   - Buat views untuk setiap page

2. **Asset Management**
   - Setup CSS framework (Tailwind, Bootstrap)
   - Buat custom CSS untuk styling
   - Buat JS untuk interaktivitas

3. **Testing**
   - Unit tests untuk business logic
   - Feature tests untuk workflow
   - Database seeding untuk test data

4. **Database Seeding**
   - Buat seeders untuk categories
   - Buat seeders untuk products
   - Buat seeders untuk admin & owner accounts

---

**Last Updated:** December 15, 2025
