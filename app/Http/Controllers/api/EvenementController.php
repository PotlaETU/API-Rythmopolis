<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EvenementRequest;
use App\Models\Evenement;
use App\Models\Prix;
use App\Models\Role;
use App\Models\Statut;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use function Laravel\Prompts\select;

class EvenementController extends Controller
{
    public function index(Request $request){
        $query = Evenement::query();

        if($request->has('type')){
            $query->where('titre', $request->type);
        }

        if($request->has('lieu')){
            $query->whereHas('lieu', function ($query) use ($request) {
                $query->where('nom', $request->lieu);
            });
        }

        if(auth()->user()->role == Role::NON_ACTIF || auth()->user()->role == Role::ACTIF){
            $query->where('date_event', '>=', now());
            $evenements = $query->with(['lieu', 'artistes'])->orderBy('date_event', 'asc')->get();

        }
        else if(auth()->user()->role == Role::GESTIONNAIRE || auth()->user()->role == Role::ADMIN){
            $evenements = $query->with(['lieu', 'artistes'])->orderBy('date_event', 'desc')->get();
        }

        return response()->json([
            'status' => 'success',
            'evenements' => $evenements,
        ]);

    }

    public function show($id){
        $evenement = Evenement::with(['lieu', 'artistes' => function ($query){
            $query->orderBy('id', 'asc');
        }])->find($id);

        $prix_disponibles = Prix::select('prix.*')
            ->where('prix.evenement_id', $id)
            ->whereNotIn('prix.id', function($query) {
                $query->select('billets.prix_id')
                    ->from('billets');
            })
            ->get();

        return response()->json([
            'status' => 'success',
            'evenement' => $evenement,
            'prix_disponibles' => $prix_disponibles,
        ]);
    }

    public function store(EvenementRequest $request){

        $evenement = new Evenement();
        $evenement->titre = $request->titre;
        $evenement->description = $request->description;
        $evenement->date_event = $request->date_event;
        $evenement->lieu_id = $request->lieu_id;
        $evenement->save();

        if($request->has('artistes')){
            foreach ($request->artistes as $artiste) {
                DB::table('participants')->insert([
                    'evenement_id' => $evenement->id,
                    'artiste_id' => $artiste,
                ]);
            }
        }

        if ($request->has('prix')) {
            foreach ($request->prix as $prixData) {
                $prix = new Prix();
                $prix->categorie = $prixData['categorie'];
                $prix->nombre = $prixData['nombre'];
                $prix->valeur = $prixData['valeur'];
                $prix->evenement_id = $evenement->id;
                $prix->save();
            }
        }

        $evenement->load(['lieu', 'artistes', 'prix']);

        return response()->json([
            'status' => 'success',
            'evenement' => $evenement,
        ]);
    }

    public function update(Request $request, $id){
        $evenement = Evenement::find($id);
        $evenement->titre = $request->titre ?? $evenement->titre;
        $evenement->description = $request->description ?? $evenement->description;
        $evenement->date_event = $request->date_event ?? $evenement->date_event;
        $evenement->lieu_id = $request->lieu_id ?? $evenement->lieu_id;
        $evenement->save();

        return response()->json([
            'status' => 'success',
            'evenement' => $evenement,
        ]);
    }

    public function updateParticipants(Request $request, $id){
        $request->validate([
            'artistes' => 'required|array',
            'artistes.*' => 'exists:artistes,id',
        ]);

        $evenement = Evenement::find($id);
        $evenement->artistes()->sync($request->artistes);

        return response()->json([
            'status' => 'success',
            'evenement' => $evenement->artistes()->get(),
        ]);
    }

    public function indexPrix(Request $request, $id){
        $evenement = Evenement::find($id);
        $query = $evenement->prix()->select('categorie', DB::raw('prix.nombre - COALESCE((SELECT SUM(quantite) FROM billets WHERE billets.prix_id = prix.id), 0) as nombre_places'));


        if($request->has('categorie')){
            $query->where('categorie', $request->categorie);
        }

        $prix = $query->get();


        return response()->json([
            'status' => 'success',
            'prix' => $prix,
        ]);
    }

    public function updatePrix(Request $request, $id, $idPrix){
        $request->validate([
            'categorie' => 'string|max:50',
            'nombre' => 'numeric',
            'valeur' => 'numeric',
        ]);

        $evenement = Evenement::find($id);
        $prix = $evenement->prix()->find($idPrix);

        if($prix) {
            $prix->categorie = $request->categorie ?? $prix->categorie;
            $prix->nombre = $request->nombre ?? $prix->nombre;
            $prix->valeur = $request->valeur ?? $prix->valeur;
            $prix->save();
            return response()->json([
                'status' => 'success',
                'prix' =>$prix,
            ]);
        }
        else {
            return response()->json([
                'status' => 'error',
                'message' => 'Prix not found',
            ], 404);
        }
    }

    public function destroy($id){
        $evenement = Evenement::find($id);
        $evenement->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Evenement deleted',
        ]);
    }
}
