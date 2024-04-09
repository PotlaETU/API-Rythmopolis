<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use OpenApi\Attributes\OpenApi;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use OpenApi\Attributes as OA;


#[OA\Info(version: "1.0", title: "API SAE G-10")]
class AuthController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    #[OA\Post(
        path: "/login",
        description: "Connecte un utilisateur",
        requestBody: new OA\RequestBody(
            description: "Les informations de connexion de l'utilisateur",
            content: new OA\MediaType(
                mediaType: "application/json",
                schema: new OA\Schema(
                    required: ["email", "password"],
                    properties: [
                        new OA\Property(
                            property: "email",
                            description: "Adresse email de l'utilisateur",
                            type: "string"
                        ),
                        new OA\Property(
                            property: "password",
                            description: "Mot de passe de l'utilisateur",
                            type: "string"
                        )
                    ],
                    type: "object"
                )
            )
        ),
        tags: ["Authentification"],
        responses: [
            new OA\Response(
                response: "200",
                description: "Utilisateur connecté",
                content: new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(
                        properties: [
                            new OA\Property(
                                property: "token",
                                description: "Jeton d'authentification JWT",
                                type: "string"
                            )
                        ],
                        type: "object"
                    )
                )
            ),
            new OA\Response(
                response: "401",
                description: "Non autorisé"
            )
        ]
    )]
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $credentials = $request->only('email', 'password');
        $token = JWTAuth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 401);
        }
        $user = Auth::user();
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer'
            ]
        ]);
    }

    #[OA\Post(
        path: "/register",
        description: "Enregistre un nouvel utilisateur",
        requestBody: new OA\RequestBody(
            description: "Les informations de connexion de l'utilisateur",
            required: true,
            content: new OA\MediaType(
                mediaType: "application/json",
                schema: new OA\Schema(
                    required: ["nom", "prenom", "adresse", "code_postal","ville","email", "password"],
                    properties: [
                        new OA\Property(
                            property: "nom",
                            description: "Nom de l'utilisateur",
                            type: "string"
                        ),
                        new OA\Property(
                            property: "prenom",
                            description: "Prénom de l'utilisateur",
                            type: "string"
                        ),
                        new OA\Property(
                            property: "adresse",
                            description: "Adresse de l'utilisateur",
                            type: "string"
                        ),
                        new OA\Property(
                            property: "code_postal",
                            description: "Code postal de l'utilisateur",
                            type: "string"
                        ),
                        new OA\Property(
                            property: "ville",
                            description: "Ville de l'utilisateur",
                            type: "string"
                        ),
                        new OA\Property(
                            property: "email",
                            description: "Adresse email de l'utilisateur",
                            type: "string"
                        ),
                        new OA\Property(
                            property: "password",
                            description: "Mot de passe de l'utilisateur",
                            type: "string"
                        )
                    ],
                    type: "object"
                )
            )
        ),
        tags: ["Authentification"],
        responses: [
            new OA\Response(
                response: "200",
                description: "Utilisateur créé"
            ),
            new OA\Response(
                response: "401",
                description: "Non autorisé"
            )
        ]
    )]
    public function register(Request $request)
    {

        DB::beginTransaction();
        $request->validate([
            'nom' => 'required|string|between:5,50',
            'prenom' => 'required|string|between:5,50',
            'adresse' => 'required|string|max:255',
            'code_postal' => 'required|string|max:10',
            'ville' => 'required|string|max:50',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6'
        ]);
        $user = User::create([
            'name' => $request->nom . ' ' . $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $client = Client::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'adresse' => $request->adresse,
            'code_postal' => $request->code_postal,
            'ville' => $request->ville,
            'user_id' => $user->id
        ]);
        DB::commit();


        $credentials = $request->only('email', 'password');
        $token = JWTAuth::attempt($credentials);

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer'
            ]
        ], 201);
    }

    #[OA\Get(
        path: "/user",
        description: "Se déconnecte l'utilisateur connecté",
        tags: ["Authentification"],
        responses: [
            new OA\Response(
                response: "200",
                description: "Utilisateur connecté"
            ),
            new OA\Response(
                response: "401",
                description: "Non autorisé"
            )
        ]
    )]
    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'User logged out successfully'
        ]);
    }

    #[OA\Get(
        path: "/refresh",
        description: "Rafraîchit le token de l'utilisateur connecté",
        tags: ["Authentification"],
        responses: [
            new OA\Response(
                response: "200",
                description: "Token rafraîchi"
            ),
            new OA\Response(
                response: "401",
                description: "Non autorisé"
            )
        ]
    )]
    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorization' => [
                'token' => Auth::refresh(),
                'type' => 'bearer'
            ]
        ]);
    }
}
