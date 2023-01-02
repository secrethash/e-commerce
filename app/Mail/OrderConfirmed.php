<?php

namespace App\Mail;

use App\Services\Cart;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Fluent;
use Shopper\Framework\Models\Shop\Order\Order;

class OrderConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @param \Shopper\Framework\Models\Shop\Order\Order $order
     * @param \Illuminate\Support\Fluent $amounts
     */
    public function __construct(
        public Order $order,
        public Fluent $amounts
    ) {}

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.orders.confirmed');
    }
}
