<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\ClientController;
use App\Http\Controllers\api\EvenementController;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::get('profil',[ClientController::class, 'profil'])->middleware('auth:api', 'checkUserRole');

Route::get('clients', [ClientController::class, 'index'])->middleware('auth:api', 'checkUserRole:'.Role::GESTIONNAIRE);

Route::get('clients/{id}', [ClientController::class, 'show'])->middleware('auth:api', 'checkUserRole:'.Role::GESTIONNAIRE);

Route::put('clients/{id}', [ClientController::class, 'update'])->middleware('auth:api', 'checkUserRole:'.Role::GESTIONNAIRE);

Route::get('evenements', [EvenementController::class, 'index'])->middleware('auth:api');

Route::get('evenements/{id}', [EvenementController::class, 'show'])->middleware('auth:api', 'checkUserRole');

Route::post('evenements', [EvenementController::class, 'store'])->middleware('auth:api', 'checkUserRole:'.Role::GESTIONNAIRE);

Route::put('evenements/{id}', [EvenementController::class, 'update'])->middleware('auth:api', 'checkUserRole:'.Role::GESTIONNAIRE);

Route::put('evenements/{id}/updateParticipants', [EvenementController::class, 'updateParticipants'])->middleware('auth:api', 'checkUserRole:'.Role::GESTIONNAIRE);

Route::get('evenements/{id}/prix', [EvenementController::class, 'indexPrix'])->middleware('auth:api', 'checkUserRole:'.Role::ACTIF);
