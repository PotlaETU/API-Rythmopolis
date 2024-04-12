<?php

namespace App\Jobs;

use App\Mail\BilletPdf;
use App\Models\Billet;
use App\Models\User;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ExportBillet implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Billet $billet;
    protected User $user;

    /**
     * Create a new job instance.
     */
    public function __construct(Billet $billet, User $user)
    {
        $this->billet = $billet;
        $this->user = $user;

        $pdf = PDF::loadView('reservations.billet', ['billet' => $billet]);
        $pdf->save(storage_path('app/public/billets/' . $billet->id . '.pdf'));
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->user->email)->send(new BilletPdf(storage_path('app/public/billets/'.$this->billet->id.'.pdf'),$this->user, $this->billet));
    }
}
