<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContributorStatusChangeMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $contributor, $msg;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contributor, $msg)
    {
        $this->contributor = $contributor;
        $this->msg = $msg;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject('Contributor Status Change Status')
            ->markdown('mail.contributor-status')
            ->with([
                'contributor' => $this->contributor,
                'msg' => $this->msg,
            ]);
    }
}
