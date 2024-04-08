<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function reservationsClient(){
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

    public function reservationsEvenement(Request $request ,$id){
        $request->validate([
            'debut' => 'date',
            'fin' => 'date',
            'client_id' => 'integer'
        ]);

        $query = Reservation::query();
        $query->where('evenement_id', $id);

        if($request->has('debut') || $request->has('fin')){
            $query->whereBetween('date_res', [$request->debut, $request->fin]);
        }

        if($request->has('client_id')){
            $query->where('client_id', $request->client_id);
        }

        $reservations = $query->get();


        $data = [];
        foreach ($reservations as $reservation) {
            $data[] = [
                'etat' => $reservation->statut,
                'date_reservation' => $reservation->date_res,
                'nb_billets' => $reservation->nb_billets,
                'montant' => $reservation->montant,
                'client' => $reservation->client_id
            ];
        }

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
}
