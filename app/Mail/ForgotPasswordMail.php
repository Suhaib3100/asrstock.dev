<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $customer, $token;
    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct($customer, $token)
    {
        $this->customer = $customer;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject('Forgot Password Verification ')
            ->markdown('mail.forgot-verification')
            ->with([
                'customer' => $this->customer,
                'resetUrl' => route('password.reset', ['token' => $this->token]),
            ]);
    }


}
