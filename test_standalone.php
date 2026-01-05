<?php
// Autoload
require __DIR__ . '/vendor/autoload.php';

// Bootstrap App
$app = require_once __DIR__ . '/bootstrap/app.php';

// Make Kernel
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

// Bootstrap
$kernel->bootstrap();

// Test Logic
try {
    $u = App\Models\User::first();
    if (!$u) {
        // If no user, factory create one
        $u = App\Models\User::factory()->create(['role' => 'customer']);
    }
    
    echo "User ID: " . $u->id . "\n";
    
    $o = App\Models\Order::create([
        'user_id' => $u->id,
        'invoice_number' => 'INV/TEST/' . rand(1000,9999), 
        'total_amount' => 10000, 
        'status' => 'pending', 
        'customer_name' => 'Test Name', 
        'customer_phone' => '08123', 
        'customer_address' => 'Addr', 
        'shipping_cost' => 5000, 
        'shipping_method' => 'gosend'
    ]);
    
    echo "SUCCESS_ORDER_ID: " . $o->id . "\n";
    
    $p = App\Models\Payment::create([
        'order_id' => $o->id,
        'payment_method' => 'transfer',
        'amount' => 10000,
        'status' => 'pending',
        'proof_image' => 'dummy.jpg',
        'paid_at' => now(),
    ]);
    echo "SUCCESS_PAYMENT_ID: " . $p->id . "\n";
} catch (\Exception $e) {
    echo "ERROR_MSG: " . $e->getMessage() . "\n";
    echo "TRACE: " . $e->getTraceAsString() . "\n";
}
