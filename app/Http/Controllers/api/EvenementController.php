<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Evenement;
use App\Models\Role;
use Illuminate\Http\Request;

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
}
