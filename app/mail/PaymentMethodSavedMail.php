<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentMethodSavedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $paymentMethod;
    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct($paymentMethod, $user)
    {
        $this->paymentMethod = $paymentMethod;
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope()
    {
        return new \Illuminate\Mail\Mailables\Envelope(
            subject: 'Payment Method Added to Your CartNova Account',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content()
    {
        return new \Illuminate\Mail\Mailables\Content(
            view: 'emails.payment-method-saved',
            with: [
                'paymentMethod' => $this->paymentMethod,
                'user' => $this->user,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments()
    {
        return [];
    }
}
