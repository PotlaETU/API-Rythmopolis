<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;


class ReservationController extends Controller
{
    #[OA\Get(
        path: "/reservations",
        description: "Récupère la liste des réservations",
        tags: ["Reservations"],
        responses: [
            new OA\Response(
                response: "200",
                description: "Liste des réservations",
            ),
            new OA\Response(
                response: "404",
                description: "Aucune réservation trouvée",
            )
        ]
    )]
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

    #[OA\Get(
        path: "/reservations/{id}",
        description: "Récupère la liste des réservations d'un événement",
        tags: ["Reservations"],
        parameters:[
            new OA\Parameter(
                name: "id",
                description: "ID de l'événement",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            ),
            new OA\Parameter(
                name: "debut",
                description: "Date de début",
                in: "query",
                schema: new OA\Schema(type: "date")
            ),
            new OA\Parameter(
                name: "fin",
                description: "Date de fin",
                in: "query",
                schema: new OA\Schema(type: "date")
            ),
            new OA\Parameter(
                name: "client_id",
                description: "ID du client",
                in: "query",
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: "200",
                description: "Liste des réservations",
            ),
            new OA\Response(
                response: "404",
                description: "Aucune réservation trouvée",
            )
        ]
    )]
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
