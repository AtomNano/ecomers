<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user', 'payment')->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }
    
    /**
     * Display order untuk approval (dari AdminOrderController)
     */
    public function show($id)
    {
        $order = Order::with(['user', 'items.product', 'payment'])->findOrFail($id);
        return view('admin.orders.verify', compact('order'));
    }
    
    /**
     * Approve payment and deduct stock (dari AdminOrderController)
     * HATI-HATI: Stok hanya berkurang saat approval, bukan saat checkout!
     */
    public function approve(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $order = Order::lockForUpdate()->findOrFail($id);

            if ($order->status !== 'pending') {
                DB::rollBack();
                return back()->with('error', 'Order ini sudah diproses sebelumnya.');
            }

            // 1. Kurangi Stok dengan lockForUpdate untuk mencegah race condition
            foreach ($order->items as $item) {
                $product = Product::lockForUpdate()->findOrFail($item->product_id);
                
                if ($product->stock < $item->quantity) {
                    throw new \Exception("Stok untuk {$product->name} tidak cukup! Sisa: {$product->stock}, Diminta: {$item->quantity}");
                }

                $product->decrement('stock', $item->quantity);
            }

            // 2. Update payment status
            $order->payment->update(['status' => 'verified']);
            
            // 3. Update order status ke payment_verified
            $order->update(['status' => 'payment_verified']);

            DB::commit();

            return redirect()->route('admin.dashboard')->with('success', 'Pembayaran diverifikasi dan stok berkurang permanen.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses: ' . $e->getMessage());
        }
    }
    
    /**
     * FATAL FIX #2: Return Stock saat Reject
     * 
     * MASALAH SEBELUMNYA:
     * - Stok dikurangi saat checkout (hard reservation)
     * - Tapi saat reject, stok tidak dikembalikan
     * - Hasilnya: Stok hilang selamanya (phantom inventory)
     * 
     * SOLUSI:
     * - Gunakan DB Transaction untuk consistency
     * - Increment stok kembali untuk setiap item
     * - Update payment & order status secara atomic
     */
    public function reject(Order $order, Request $request)
    {
        $request->validate(['reason' => 'required|string|min:5']);
        
        if ($order->payment->status !== 'pending') {
            return back()->with('error', 'Pembayaran sudah diverifikasi');
        }

        try {
            DB::transaction(function() use ($order, $request) {
                // STEP 1: Kembalikan stok untuk setiap item
                foreach ($order->items as $item) {
                    $item->product->increment('stock', $item->quantity);
                    
                    // Log untuk audit trail
                    \Log::info("Stock returned", [
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'order_id' => $order->id,
                        'reason' => 'Order rejected by admin'
                    ]);
                }

                // STEP 2: Update payment status
                $order->payment->update([
                    'status' => 'rejected',
                    'notes' => $request->reason
                ]);

                // STEP 3: Update order status
                $order->update(['status' => 'cancelled']);
            });

            return back()->with('success', 
                'Pembayaran ditolak dan stok dikembalikan ke gudang');
        
        } catch (\Exception $e) {
            \Log::error("Error rejecting order: " . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    public function ship(Order $order)
    {
        if ($order->status !== 'payment_verified') {
            return back()->with('error', 'Status order tidak sesuai untuk pengiriman');
        }
        
        $order->update(['status' => 'shipped']);
        
        return back()->with('success', 'Order sedang dikirim');
    }
    
    public function complete(Order $order)
    {
        if ($order->status !== 'shipped') {
            return back()->with('error', 'Order belum dikirim');
        }
        
        $order->update(['status' => 'completed']);
        
        return back()->with('success', 'Order selesai');
    }

    // Customer-facing payment methods
    public function showPayment($invoice_number)
    {
        $order = Order::where('invoice_number', $invoice_number)->firstOrFail();
        
        // SECURITY FIX: Cek kepemilikan order
        // Jika user login dan bukan pemilik, tolak akses
        if (auth()->check() && $order->user_id !== auth()->id()) {
            abort(403, 'Anda tidak berhak melihat pesanan ini.');
        }
        
        // Jika status bukan pending, tendang user
        if ($order->status !== 'pending') {
            return redirect()->route('orders.show', $order->invoice_number)
                ->with('info', 'Pesanan ini sedang diproses atau sudah selesai.');
        }

        return view('orders.payment', compact('order'));
    }

    public function uploadProof(Request $request, $id)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $order = Order::findOrFail($id);

        // Prevent uploading if status not pending
        if ($order->status !== 'pending') {
            return redirect()->route('orders.show', $order->invoice_number)
                ->with('error', 'Order ini sudah diproses.');
        }

        if ($request->hasFile('payment_proof')) {
            // Simpan di storage/app/public/payment_proofs
            $path = $request->file('payment_proof')->store('payment_proofs', 'public');
            
            $order->update([
                'payment_proof' => $path,
                'status' => 'waiting_verification',
            ]);
        }

        // Redirect ke halaman sukses dengan trigger WA
        return redirect()->route('orders.success', $order->invoice_number);
    }

    public function showSuccess($invoice_number)
    {
        $order = Order::where('invoice_number', $invoice_number)->firstOrFail();
        return view('orders.success', compact('order'));
    }
}
