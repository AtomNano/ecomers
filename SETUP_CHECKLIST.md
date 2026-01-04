# 🎯 Setup Checklist - Grosir Berkat Ibu

Panduan lengkap untuk menyelesaikan setup dan implementasi website e-commerce.

---

## ✅ Phase 1: Project Setup (COMPLETED)

- [x] Create Laravel project
- [x] Setup database migrations
- [x] Create all models with relationships
- [x] Setup routes (web.php)
- [x] Create all controllers (skeleton)
- [x] Setup middleware for role-based access
- [x] Register middleware in bootstrap/app.php
- [x] Create documentation (README.md, IMPLEMENTATION_GUIDE.md)

### Verified Files
- ✅ `database/migrations/*` - All 11 migrations
- ✅ `app/Models/*` - All 8 models
- ✅ `routes/web.php` - Complete routes definition
- ✅ `app/Http/Controllers/*` - All 14 controllers
- ✅ `app/Http/Middleware/*` - All 3 middleware
- ✅ `bootstrap/app.php` - Middleware registered

---

## 🔄 Phase 2: Controller Implementation

### Authentication Controllers

#### [ ] AuthController.php
- [ ] `showLogin()` - Show login form
- [ ] `login()` - Handle login submission
  - [ ] Validate email & password
  - [ ] Check credentials
  - [ ] Redirect based on role (admin/owner/customer)
  - [ ] Set flash messages
- [ ] `logout()` - Handle logout
  - [ ] Clear session
  - [ ] Redirect to home

#### [ ] RegisterController.php
- [ ] `showRegister()` - Show registration form
- [ ] `register()` - Handle registration
  - [ ] Validate input (name, email, password, phone, address, province, city, district)
  - [ ] Check email unique
  - [ ] Create new user with role='customer'
  - [ ] Hash password
  - [ ] Auto login user
  - [ ] Redirect to customer home

#### [ ] ForgotPasswordController.php
- [ ] `showForm()` - Show forgot password form
- [ ] `sendReset()` - Send reset link to email
  - [ ] Validate email exists
  - [ ] Generate reset token
  - [ ] Send email with reset link
  - [ ] Show success message
- [ ] `showReset($token)` - Show reset password form
- [ ] `resetPassword()` - Handle password reset
  - [ ] Validate token & inputs
  - [ ] Update user password
  - [ ] Redirect to login

### Customer Controllers

#### [ ] Customer/HomeController.php
- [ ] `index()` - Show home page
  - [ ] Get latest 6 products
  - [ ] Get best selling 6 products
  - [ ] Get all categories
  - [ ] Get store settings
  - [ ] Return view with data
- [ ] `about()` - Show about page
  - [ ] Get store settings
  - [ ] Display store info, location, maps, phone
- [ ] `dashboard()` - Show customer dashboard
  - [ ] Show welcome message
  - [ ] Show quick links
- [ ] `orders()` - Show order history
  - [ ] Get user's orders paginated
  - [ ] Show status & dates

#### [ ] Customer/ProductController.php
- [ ] `index()` - List all products
  - [ ] Load with category relationship
  - [ ] Support category filter
  - [ ] Paginate (12 per page)
  - [ ] Return products & categories
- [ ] `show($id)` - Show product detail
  - [ ] Load product with category
  - [ ] Get 4 related products
  - [ ] Show 3 price options (unit, bulk, dozen)
  - [ ] Show current stock

#### [ ] Customer/CartController.php
- [ ] `add()` - Add item to cart
  - [ ] Validate product_id, quantity, price_type
  - [ ] Check if item already in cart
  - [ ] If yes: increment quantity
  - [ ] If no: create new cart item
  - [ ] Flash success message
- [ ] `index()` - Show cart items
  - [ ] Load user's cart items with products
  - [ ] Calculate total price
  - [ ] Show item count
- [ ] `update()` - Update quantity
  - [ ] Validate quantity
  - [ ] Update cart item
  - [ ] Recalculate total
- [ ] `remove()` - Delete item from cart
  - [ ] Delete cart item
  - [ ] Flash success
- [ ] `clear()` - Clear entire cart
  - [ ] Delete all items
  - [ ] Flash success

#### [ ] Customer/CheckoutController.php
- [ ] `index()` - Show checkout form
  - [ ] Check if cart empty
  - [ ] Calculate subtotal
  - [ ] Load user info
  - [ ] Show shipping options (GoSend/Pickup/Custom)
  - [ ] Show payment methods (Transfer/QRIS)
- [ ] `store()` - Process checkout
  - [ ] Validate inputs
  - [ ] Calculate shipping cost
  - [ ] Create Order record
  - [ ] Create OrderItems for each cart item
  - [ ] Update product stocks
  - [ ] Create Payment record
  - [ ] Clear user's cart
  - [ ] Redirect to payment page

#### [ ] Customer/PaymentController.php
- [ ] `show($orderId)` - Show payment form
  - [ ] Get order with items
  - [ ] Check authorization
  - [ ] Show payment instructions
  - [ ] Show payment method info
- [ ] `uploadProof()` - Handle payment proof upload
  - [ ] Validate image
  - [ ] Store image to storage
  - [ ] Update Payment record
  - [ ] Set status to 'pending' (waiting admin verification)
  - [ ] Flash success message
- [ ] `status()` - Show payment status
  - [ ] Get order & payment
  - [ ] Show current status
  - [ ] If verified: show "waiting shipment"
  - [ ] If rejected: show rejection reason
  - [ ] Show WhatsApp contact icon

### Admin Controllers

#### [ ] Admin/DashboardController.php
- [ ] `index()` - Show admin dashboard
  - [ ] Count total orders today
  - [ ] Count pending payments
  - [ ] Count shipped orders
  - [ ] Get recent orders
  - [ ] Get revenue stats

#### [ ] Admin/ProductController.php
- [ ] `index()` - List all products
  - [ ] Paginate (10 per page)
  - [ ] Show stock status
  - [ ] Show edit/delete buttons
- [ ] `create()` - Show create product form
  - [ ] Load categories
  - [ ] Show form for: name, desc, category, image, 3 prices, stock
- [ ] `store()` - Save new product
  - [ ] Validate inputs
  - [ ] Handle image upload
  - [ ] Create product
  - [ ] Flash success
- [ ] `edit($id)` - Show edit form
  - [ ] Load product
  - [ ] Load categories
  - [ ] Pre-fill form
- [ ] `update()` - Update product
  - [ ] Validate inputs
  - [ ] Handle image upload (optional)
  - [ ] Update product
  - [ ] Flash success
- [ ] `destroy($id)` - Delete product
  - [ ] Check if has orders (prevent delete if yes)
  - [ ] Delete product
  - [ ] Delete image file
  - [ ] Flash success
- [ ] `updateStock()` - Update stock quickly
  - [ ] Validate stock value
  - [ ] Update product stock
  - [ ] Flash success (AJAX response)

#### [ ] Admin/OrderController.php
- [ ] `index()` - List all orders
  - [ ] Load with user & payment
  - [ ] Sort by latest
  - [ ] Paginate (10 per page)
  - [ ] Show status badge
- [ ] `show($id)` - Show order details
  - [ ] Load order with items & payment
  - [ ] Show all item details
  - [ ] Show payment proof
  - [ ] Show customer info
  - [ ] Show action buttons
- [ ] `verifyPayment()` - Verify payment
  - [ ] Update payment status to 'verified'
  - [ ] Update order status to 'payment_verified'
  - [ ] Save verification notes
  - [ ] Send WhatsApp notification to customer
  - [ ] Flash success
- [ ] `rejectPayment()` - Reject payment
  - [ ] Update payment status to 'rejected'
  - [ ] Save rejection reason
  - [ ] Return product stocks
  - [ ] Update order status to 'cancelled'
  - [ ] Flash success
- [ ] `ship()` - Mark as shipped
  - [ ] Update order status to 'shipped'
  - [ ] Set shipped_at timestamp
  - [ ] Flash success

#### [ ] Admin/ReportController.php
- [ ] `index()` - Show financial report
  - [ ] Calculate total revenue (completed orders only)
  - [ ] Calculate total orders count
  - [ ] Get monthly revenue data
  - [ ] Get weekly revenue data
  - [ ] Prepare chart data
- [ ] `export()` - Export report to CSV/Excel
  - [ ] Get all completed orders
  - [ ] Generate CSV with: date, product, qty, price, total
  - [ ] Download file

### Owner Controllers

#### [ ] Owner/DashboardController.php
- [ ] `index()` - Show owner dashboard
  - [ ] Same as admin dashboard
  - [ ] Plus admin activity log

#### [ ] Owner/CustomerController.php
- [ ] `index()` - List all customers
  - [ ] Get customers (role='customer')
  - [ ] Paginate (10 per page)
  - [ ] Show name, email, phone, join date
- [ ] `show($id)` - Show customer detail
  - [ ] Load customer with all orders
  - [ ] Show order history
  - [ ] Show total spent
- [ ] `create()` - Show add customer form
  - [ ] Show form for registration fields
- [ ] `store()` - Create new customer
  - [ ] Validate inputs
  - [ ] Create user with role='customer'
  - [ ] Flash success
- [ ] `edit($id)` - Show edit form
  - [ ] Load customer data
  - [ ] Pre-fill form
- [ ] `update()` - Update customer
  - [ ] Validate inputs
  - [ ] Update user
  - [ ] Flash success
- [ ] `destroy()` - Delete customer
  - [ ] Delete user account
  - [ ] Flash success

#### [ ] Owner/ReportController.php
- [ ] `index()` - Show owner reports
  - [ ] Same as admin reports
  - [ ] Plus admin activity stats

---

## 🎨 Phase 3: Frontend Views

### Layout Views
- [ ] `resources/views/layouts/app.blade.php` - Main layout
- [ ] `resources/views/layouts/customer.blade.php` - Customer layout
- [ ] `resources/views/layouts/admin.blade.php` - Admin layout
- [ ] `resources/views/layouts/owner.blade.php` - Owner layout

### Authentication Views
- [ ] `resources/views/auth/login.blade.php`
- [ ] `resources/views/auth/register.blade.php`
- [ ] `resources/views/auth/forgot-password.blade.php`
- [ ] `resources/views/auth/reset-password.blade.php`

### Customer Views
- [ ] `resources/views/customer/home.blade.php` - Home page
- [ ] `resources/views/customer/about.blade.php` - About page
- [ ] `resources/views/customer/products/index.blade.php` - Product list
- [ ] `resources/views/customer/products/show.blade.php` - Product detail
- [ ] `resources/views/customer/cart.blade.php` - Cart view
- [ ] `resources/views/customer/checkout.blade.php` - Checkout form
- [ ] `resources/views/customer/payment/show.blade.php` - Payment form
- [ ] `resources/views/customer/payment/status.blade.php` - Payment status
- [ ] `resources/views/customer/orders.blade.php` - Order history

### Admin Views
- [ ] `resources/views/admin/dashboard.blade.php` - Dashboard
- [ ] `resources/views/admin/products/index.blade.php` - Product list
- [ ] `resources/views/admin/products/create.blade.php` - Add product
- [ ] `resources/views/admin/products/edit.blade.php` - Edit product
- [ ] `resources/views/admin/orders/index.blade.php` - Order list
- [ ] `resources/views/admin/orders/show.blade.php` - Order detail
- [ ] `resources/views/admin/reports/index.blade.php` - Report page

### Owner Views
- [ ] `resources/views/owner/dashboard.blade.php` - Dashboard
- [ ] `resources/views/owner/customers/index.blade.php` - Customer list
- [ ] `resources/views/owner/customers/show.blade.php` - Customer detail
- [ ] `resources/views/owner/customers/create.blade.php` - Add customer
- [ ] `resources/views/owner/customers/edit.blade.php` - Edit customer
- [ ] `resources/views/owner/reports/index.blade.php` - Report page

---

## 📦 Phase 4: Assets & Styling

- [ ] Setup Tailwind CSS or Bootstrap
- [ ] Create custom CSS for branding
- [ ] Create custom JavaScript for interactivity
- [ ] Add Font Awesome icons
- [ ] Create responsive design

---

## 🧪 Phase 5: Testing & Seeding

- [ ] Create database seeders
  - [ ] CategorySeeder
  - [ ] ProductSeeder
  - [ ] UserSeeder (admin, owner, customers)
  - [ ] StoreSetting seeder
- [ ] Create unit tests
- [ ] Create feature tests
- [ ] Manual testing checklist

---

## 📋 Deployment Checklist

- [ ] Set `.env` for production
- [ ] Setup MySQL database
- [ ] Generate app key
- [ ] Run migrations
- [ ] Run seeders
- [ ] Setup storage symlink
- [ ] Configure email (SMTP)
- [ ] Setup file upload paths
- [ ] Test all features
- [ ] Setup backup strategy
- [ ] Setup monitoring
- [ ] Setup SSL certificate

---

## 🚀 Go Live Checklist

- [ ] All features tested
- [ ] Database optimized
- [ ] Security headers configured
- [ ] CORS configured
- [ ] Rate limiting setup
- [ ] Error logging setup
- [ ] Performance optimized
- [ ] Mobile responsive verified
- [ ] Cross-browser tested
- [ ] Documentation completed
- [ ] Team trained
- [ ] Support process ready

---

## 📊 Current Status

**Completed:** Phase 1 (100%)
**In Progress:** Phase 2 (0%)
**Not Started:** Phases 3-5

**Estimated Timeline:**
- Phase 2 (Controllers): 2-3 weeks
- Phase 3 (Views): 2-3 weeks
- Phase 4 (Assets): 1 week
- Phase 5 (Testing): 1 week
- **Total: 6-8 weeks**

---

**Last Updated:** December 15, 2025  
**Version:** 1.0.0
