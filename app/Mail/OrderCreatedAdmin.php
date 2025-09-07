<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderCreatedAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this->from('info@kidzcorner.shop', 'KidzCorner 🧸')
                    ->to('info@kidzcorner.shop')
                    ->subject('📦 New Order Created #' . $this->order->id)
                    ->markdown('emails.orders.admin');
    }
}
