<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Lieux;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "API SAE G-10",
    description: "API pour la SAE"
),
    OA\Server(
        url: "http://localhost:8000/api"
    )]

class LieuController extends Controller
{
    #[OA\Get(
        path: "/lieux",
        description: "Récupère la liste des lieux",
        tags: ["Lieux"],
        responses: [
            new OA\Response(
                response: "200",
                description: "Liste des lieux",
            ),
            new OA\Response(
                response: "404",
                description: "Aucun lieu trouvé",
            )
        ]
    )]
    public function index(){
        $lieux = Lieux::all();

        return response()->json([
            'status' => 'success',
            'lieux' => $lieux,
        ]);
    }
}
