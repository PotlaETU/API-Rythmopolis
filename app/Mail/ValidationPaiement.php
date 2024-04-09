<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Envelope;

class ValidationPaiement extends Mailable
{
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from : new Address('example@example.com', 'Example'),
            subject: 'Validation de paiement'
        );
    }

    public function build(): ValidationPaiement
    {
        return $this->view('reservations.validation_paiement')->with([
            'user' => $this->user
        ]);
    }
}
