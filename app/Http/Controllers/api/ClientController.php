<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

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

    public function index(Request $request){

        if(empty($request->all())){
            $clients = Client::all();
            return response()->json([
                'status' => 'success',
                'clients' => $clients
            ]);
        }

        $quuery = Client::query();

        if($request->has('search')){
            $quuery->where('nom', 'like', '%' .$request->search . '%');
        }

        if ($request->has('sort')){
            $sort = $request->sort;
            $order = $request->order ?? 'asc';

            if(in_array($sort, ['nom', 'ville'])){
                $quuery->orderBy($sort, $order);
            }
        }

        $clients = $quuery->get();

        return response()->json([
            'status' => 'success',
            'clients' => $clients
        ]);
    }
}
