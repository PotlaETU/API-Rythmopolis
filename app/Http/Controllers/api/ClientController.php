<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use function PHPUnit\Framework\isEmpty;
use function Webmozart\Assert\Tests\StaticAnalysis\inArray;

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

    public function show($id)
    {
        $client = Client::find($id);
        if($client){
            $user = $client->user()->first();
            $reservation = $client->reservations()->get();
            return response()->json([
                'status' => 'success',
                'client' => $client,
                'user' => $user,
                'reservation' => $reservation
            ]);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Client not found'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $client = Client::find($id);
        if($client){
            $user = $client->user()->first();

            $client->nom = $request->nom ?? $client->nom;
            $client->prenom = $request->prenom ?? $client->prenom;
            $client->avatar = $request->avatar ?? $client->avatar;
            $client->adresse = $request->adresse ?? $client->adresse;
            $client->code_postal = $request->code_postal ?? $client->code_postal;
            $client->ville = $request->ville ?? $client->ville;

            $user->name = $request->name ?? $user->name;
            $user->email = $request->email ?? $user->email;
            if($request->has('password')){
                $user->password = Hash::make($request->password);
            }
            if($request->has('role')){
                if ($request->role == Role::ACTIF || $request->role == Role::NON_ACTIF) {
                    $user->role = $request->role;
                } else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Role not found or invalid'
                ], 500);
                }
            }
            $client->save();
            $user->save();
            return response()->json([
                'status' => 'success',
                'client' => $client,
                'user' => $user
            ]);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Client not found'
            ], 404);
        }
    }
}
