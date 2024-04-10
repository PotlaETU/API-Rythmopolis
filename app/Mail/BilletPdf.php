<?php

namespace App\Mail;

use App\Models\Billet;
use App\Models\User;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Support\Facades\Log;

class BilletPdf extends Mailable
{
    protected $filePath;
    protected User $user;
    protected Billet $billet;
    protected $evenement;
    public function __construct(string $filePath,User $user, Billet $billet)
    {
        $this->filePath = $filePath;
        $this->user = $user;
        $this->billet = $billet;
        $this->evenement = $billet->reservation->evenement;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from : new Address('example@example.com', 'Example'),
            subject: 'Vos billets ici'
        );
    }

    public function build(): void
    {
        $this->view('reservations.billet')->with([
            'user' => $this->user,
            'billet' => $this->billet,
        ])->attachements();
    }

    public function attachements(){
        $this->attach($this->filePath);
    }


}
