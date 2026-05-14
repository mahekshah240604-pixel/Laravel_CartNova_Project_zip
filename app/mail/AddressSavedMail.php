<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class AddressSavedMail extends Mailable
{
    public $address;

    // ✅ constructor MUST
    public function __construct($address)
    {
        $this->address = $address;
    }

    public function build()
    {
        return $this->subject('Address Saved Successfully')
                    ->view('emails.address-saved');
    }
}