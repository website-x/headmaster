<?php

namespace App\Mail;

use App\Models\Fees;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentReceived extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $fees;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Fees $fees)
    {
        $this->fees = $fees;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.paymentReceived');
    }
}
