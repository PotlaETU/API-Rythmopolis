<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Evenement;
use App\Models\Lieux;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Tests\TestCase;

class EvenementTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function testIndex(){
        Lieux::factory(10)->create();

        Evenement::Factory(10)->create();
        $user = User::create([
            'name' => "Robert Duchmol",
            'email' => "robert.duchmol@domain.fr",
            'email_verified_at' => now(),
            'password' => Hash::make('GrosSecret'),
            'remember_token' => Str::random(10),
            'role' => Role::ACTIF
        ]);
        $client = Client::factory()->create([
            'nom' => "Duchmol",
            'prenom' => "Robert",
            'avatar' => "https://randomuser.me/api/port",
            'adresse' => "Rue de l'Université",
            'code_postal' => "62300",
            'ville' => "Lens",
            'user_id' => $user->id
        ]);
        $user->save();
        $credentials = ['email' => $user->email, 'password' => 'GrosSecret'];
        $token = JWTAuth::attempt($credentials);
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->getJson('api/evenements');

        $response->assertStatus(200);
    }
}
