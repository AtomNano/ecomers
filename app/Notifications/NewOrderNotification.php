<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification
{
    use Queueable;

    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'message' => 'Pesanan baru #' . ($this->order->invoice_number ?? $this->order->id),
            'amount' => $this->order->total_amount,
            'user' => $this->order->user->name,
            'time' => now(),
            // Assuming current route structure; using admin.orders.show for action.
            'link' => route('admin.orders.show', $this->order->id),
        ];
    }
}
