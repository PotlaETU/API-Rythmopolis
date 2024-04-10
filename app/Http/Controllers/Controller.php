<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Attributes as OA;
#[OA\Info(
    version: "1.0.0",
    description: "API de la SAE G-10. Pour l'utiliser, il faut se connecter avec un compte utilisateur et obtenir un token d'authentification. Ensuite, il faut ajouter ce token dans la section Authentification.",
    title: "API G-10"
)]
#[OA\Server(
    url: "http://localhost:8000/api"
)]
#[OA\SecurityScheme(
    securityScheme: "bearerAuth",
    type: "http",
    bearerFormat: "JWT",
    scheme: "bearer"
)]

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
