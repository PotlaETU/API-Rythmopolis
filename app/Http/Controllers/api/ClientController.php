<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use function PHPUnit\Framework\isEmpty;
use function Webmozart\Assert\Tests\StaticAnalysis\inArray;
use OpenApi\Attributes as OA;


class ClientController extends Controller
{

    #[OA\Get(
        path: "/profil",
        description: "Récupère le profil du client",
        tags: ["Client"],
        responses: [
            new OA\Response(
                response: "200",
                description: "Profil du client",
            ),
            new OA\Response(
                response: "404",
                description: "Client non trouvé",
            )
        ]
    )]
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

    #[OA\Get(
        path: "/clients",
        description: "Récupère la liste des clients",
        tags: ["Client"],
        parameters:[
            new OA\Parameter(
                name: "search",
                description: "Rechercher par nom",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "string")
            ),
            new OA\Parameter(
                name: "sort",
                description: "Trier par nom ou ville",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "string")
            )
        ],
        responses: [
            new OA\Response(
                response: "200",
                content: new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(
                        properties: [
                            new OA\Property(
                                property: "status",
                                type: "string"
                            ),
                            new OA\Property(
                                property: "clients",
                                type: "array",
                                items: new OA\Items(ref: "#/components/schemas/Client")
                            )
                        ]
                    )
                ),
            ),
            new OA\Response(
                response: "404",
                description: "Aucun client trouvé",
            )
        ]
    )]
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

    #[OA\Get(
        path: "/clients/{id}",
        description: "Récupère le client par son ID",
        tags: ["Client"],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "ID du client",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: "200",
                content: new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(
                        properties: [
                            new OA\Property(
                                property: "status",
                                type: "string"
                            ),
                            new OA\Property(
                                property: "client",
                                ref: "#/components/schemas/Client"
                            ),
                            new OA\Property(
                                property: "user",
                                ref: "#/components/schemas/User"
                            ),
                        ]
                    )
                ),
            ),
            new OA\Response(
                response: "404",
                description: "Client non trouvé",
            )
        ]
    )]
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

    #[OA\Put(
        path: "/clients/{id}",
        description: "Mettre à jour le client",
        requestBody: new OA\RequestBody(
            description: "Données à mettre à jour",
            required: true,
            content: new OA\MediaType(
                mediaType: "application/json",
                schema: new OA\Schema(
                    properties: [
                        new OA\Property(
                            property: "client",
                            ref: "#/components/schemas/Client"
                        ),
                    ],
                    type: "object"
                )
            )
        ),
        tags: ["Client"],
        responses: [
            new OA\Response(
                response: "200",
                content: new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(
                        properties: [
                            new OA\Property(
                                property: "status",
                                type: "string"
                            ),
                            new OA\Property(
                                property: "client",
                                ref: "#/components/schemas/Client"
                            ),
                            new OA\Property(
                                property: "user",
                                ref: "#/components/schemas/User"
                            )
                        ]
                    )
                ),
            ),
            new OA\Response(
                response: "404",
                description: "Client non trouvé",
            )
        ]
    )]
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
