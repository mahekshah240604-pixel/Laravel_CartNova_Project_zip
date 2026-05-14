<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GiftCardSavedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $giftCard;
    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct($giftCard, $user)
    {
        $this->giftCard = $giftCard;
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope()
    {
        return new \Illuminate\Mail\Mailables\Envelope(
            subject: 'Gift Card Added to Your CartNova Account',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content()
    {
        return new \Illuminate\Mail\Mailables\Content(
            view: 'emails.gift-card-saved',
            with: [
                'giftCard' => $this->giftCard,
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
