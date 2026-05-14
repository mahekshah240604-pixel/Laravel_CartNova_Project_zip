<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerSupportTicketMail extends Mailable
{
    use Queueable, SerializesModels;

    public $supportTicket;
    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct($supportTicket, $user)
    {
        $this->supportTicket = $supportTicket;
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope()
    {
        return new \Illuminate\Mail\Mailables\Envelope(
            subject: 'Support Ticket Created - CartNova (Ticket #' . $this->supportTicket->formatted_ticket_number . ')',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content()
    {
        return new \Illuminate\Mail\Mailables\Content(
            view: 'emails.customer-support-ticket',
            with: [
                'supportTicket' => $this->supportTicket,
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
