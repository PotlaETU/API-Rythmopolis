<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Lieux;
use Illuminate\Http\Request;

class LieuController extends Controller
{
    public function index(){
        $lieux = Lieux::all();

        return response()->json([
            'status' => 'success',
            'lieux' => $lieux,
        ]);
    }
}
