<?php

namespace App\Console\Commands;

use App\Models\Reservation;
use App\Models\Statut;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DeleteExpiredReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservations:delete-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Supprimer les réservation qui sont En attente depuis plus de 12h';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredReservations = Reservation::where('statut', '=', Statut::EN_ATTENTE)
            ->where('date_res', '<=',now()->subHours(12))
            ->get();

        foreach ($expiredReservations as $reservation) {
            $reservation->delete();
        }
        $this->info('Les réservations expirées ont été supprimées');
    }
}
