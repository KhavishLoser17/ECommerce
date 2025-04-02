<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ValidateMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your Order is Ready for Pickup - BESTLINK COLLEGE')
                    ->view('emails.order-pickup')
                    ->with([
                        'studentName' => $this->data['studentName'],
                        'orderId' => $this->data['orderId'],
                        'pickupDate' => $this->data['pickupDate'],
                        'pickupTime' => $this->data['pickupTime'],
                        'additionalNotes' => $this->data['additionalNotes'],
                        'year' => $this->data['year']
                    ]);
    }
}
