<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderCreatedCustomer extends Mailable
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
                    ->to($this->order->email)
                    ->subject('✅ Your Order #' . $this->order->id . ' has been received')
                    ->markdown('emails.orders.customer');
    }
}
