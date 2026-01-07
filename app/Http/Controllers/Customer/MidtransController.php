<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransController extends Controller
{
    public function notificationHandler(Request $request)
    {
        // Set konfigurasi
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        try {
            $notif = new Notification();
            
            $transaction = $notif->transaction_status;
            $type = $notif->payment_type;
            $orderId = $notif->order_id; // Invoice number
            $fraud = $notif->fraud_status;

            // Cari order berdasarkan invoice ID
            $order = Order::where('invoice_number', $orderId)->first();

            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            if ($transaction == 'capture') {
                if ($type == 'credit_card') {
                    if ($fraud == 'challenge') {
                        $order->update(['status' => 'pending']); // Challenge by FDS
                    } else {
                        $this->setSuccess($order);
                    }
                }
            } else if ($transaction == 'settlement') {
                $this->setSuccess($order);
            } else if ($transaction == 'pending') {
                $order->update(['status' => 'pending']);
            } else if ($transaction == 'deny') {
                $this->setFailed($order);
            } else if ($transaction == 'expire') {
                $this->setFailed($order);
            } else if ($transaction == 'cancel') {
                $this->setFailed($order);
            }

            return response()->json(['message' => 'Notification processed']);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Midtrans Callback Error: ' . $e->getMessage());
            return response()->json(['message' => 'Error processing notification'], 500);
        }
    }

    private function setSuccess($order)
    {
        if ($order->status != 'payment_verified' && $order->status != 'completed') {
            // Update status payment & order
            $order->payment()->update(['status' => 'verified']);
            $order->update(['status' => 'payment_verified']);
            
            // Note: Stok sudah dikurangi saat checkout (hard reserve), jadi tidak perlu kurangi lagi
        }
    }

    private function setFailed($order)
    {
        // Jika failed/expire, kembalikan stok
        if ($order->status != 'cancelled') {
            foreach ($order->items as $item) {
                $item->product->increment('stock', $item->quantity);
            }
            
            $order->payment()->update(['status' => 'failed']);
            $order->update(['status' => 'cancelled']);
        }
    }
}
