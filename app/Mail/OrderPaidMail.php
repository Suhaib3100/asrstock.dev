<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderPaidMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $customer, $order_number;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($customer, $order_number)
    {
        $this->customer = $customer;
        $this->order_number = $order_number;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject('Order Paid')
            ->markdown('mail.paid-order')
            ->with([
                'customer' => $this->customer,
                'order_number' => $this->order_number,
            ]);
    }
}
