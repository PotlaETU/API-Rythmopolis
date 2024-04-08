<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index(){
        $user = Auth::user();
        $client_id = $user->client->id;
        $client = Client::find($client_id);
        $reservations = $client->reservations()->get();
        $data = [];
        foreach ($reservations as $reservation) {
            $data[] = [
                'etat' => $reservation->statut,
                'date_reservation' => $reservation->date_res,
                'nb_billets' => $reservation->nb_billets,
                'montant' => $reservation->montant,
            ];
        }

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
}
