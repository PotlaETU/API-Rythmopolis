<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function profil(Request $request)
    {
        $user = $request->user();
        $client = $user->client;
        return response()->json([
            'status' => 'success',
            'client' => [
                'nom' => $client->nom,
                'prenom' => $client->prenom,
                'adresse' => $client->adresse,
                'code_postal' => $client->code_postal,
                'ville' => $client->ville,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],
        ]);
    }
}
