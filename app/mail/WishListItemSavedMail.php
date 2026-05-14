<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WishlistItemSavedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $wishlistItem;
    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct($wishlistItem, $user)
    {
        $this->wishlistItem = $wishlistItem;
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope()
    {
        return new \Illuminate\Mail\Mailables\Envelope(
            // subject: 'Item Added to Your CartNova Wishlist',
              subject: '❤️ ' . $this->wishlistItem->product->name . ' added to your wishlist',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content()
    {
        return new \Illuminate\Mail\Mailables\Content(
            view: 'emails.wishlist-item-saved',
            with: [
                'wishlistItem' => $this->wishlistItem,
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
