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

        $evenement->load(['lieu', 'artistes']);

        return response()->json([
            'status' => 'success',
            'evenement' => $evenement,
        ]);
    }
}
