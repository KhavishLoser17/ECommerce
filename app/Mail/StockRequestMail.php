<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StockRequestMail extends Mailable
{
    use Queueable, SerializesModels;
    public $requestData;

    /**
     * Create a new message instance.
     */
    public function __construct($requestData)
    {
        $this->requestData = $requestData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Stock Request',
        );
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $product = $this->requestData['product_name'];
        $quantity = $this->requestData['quantity'] ?? 'N/A';

        // Build size information if applicable
        $sizes = '';
        if (isset($this->requestData['size_s']) && $this->requestData['size_s'] > 0) {
            $sizes .= "Small: " . $this->requestData['size_s'] . "\n";
        }
        if (isset($this->requestData['size_m']) && $this->requestData['size_m'] > 0) {
            $sizes .= "Medium: " . $this->requestData['size_m'] . "\n";
        }
        if (isset($this->requestData['size_l']) && $this->requestData['size_l'] > 0) {
            $sizes .= "Large: " . $this->requestData['size_l'] . "\n";
        }
        if (isset($this->requestData['size_xl']) && $this->requestData['size_xl'] > 0) {
            $sizes .= "XL: " . $this->requestData['size_xl'] . "\n";
        }
        if (isset($this->requestData['size_xxl']) && $this->requestData['size_xxl'] > 0) {
            $sizes .= "XXL: " . $this->requestData['size_xxl'] . "\n";
        }

        $note = $this->requestData['note'] ?? 'No special instructions';

        $messageBody = "Product: $product\n\n";
        $messageBody .= "Quantity: $quantity\n\n";

        if (!empty($sizes)) {
            $messageBody .= "Sizes:\n$sizes\n";
        }

        $messageBody .= "NOTE: $note\n\n";
        $messageBody .= "This request was sent from BESTLINK COLLEGE OF THE PHILIPPINES.";

        return $this->text('emails.stock_request')
                    ->with(['message' => $messageBody]);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
