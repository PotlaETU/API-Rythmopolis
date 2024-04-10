<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Tests\TestCase;

class ClientControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function testProfil()
    {
        $user = User::create([
            'name' => "Maori Sayoud",
            'email' => "maori.sayoud@domain.fr",
            'email_verified_at' => now(),
            'password' => Hash::make('GrosSecret'),
            'remember_token' => Str::random(10),
            'role' => Role::ACTIF
        ]);
        $client = Client::factory()->create([
            'nom' => "Sayoud",
            'prenom' => "Maori",
            'avatar' => "https://randomuser.me/api/port",
            'adresse' => "Rue de l'Université",
            'code_postal' => "62300",
            'ville' => "Lens",
            'user_id' => $user->id
        ]);
        $user->save();
        $credentials = ['email' => $user->email, 'password' => 'GrosSecret'];
        $token = JWTAuth::attempt($credentials);
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->getJson('api/profil');

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'client' => [
                'nom' => $client->nom,
                'prenom' => $client->prenom,
                'adresse' => $client->adresse,
                'code_postal' => $client->code_postal,
                'ville' => $client->ville,
                'name' => $user->name,
                'email' => $user->email,
                'role' => Role::ACTIF,
            ],
        ]);
    }

    /**
     * @test
     */
    public function listeClientsActif()
    {
        $user = User::create([
            'name' => "Maori Sayoud",
            'email' => "maori.sayoud@domain.fr",
            'email_verified_at' => now(),
            'password' => Hash::make('GrosSecret'),
            'remember_token' => Str::random(10),
            'role' => Role::ACTIF
        ]);
        $client = Client::factory()->create([
            'nom' => "Sayoud",
            'prenom' => "Maori",
            'avatar' => "https://randomuser.me/api/port",
            'adresse' => "Rue de l'Université",
            'code_postal' => "62300",
            'ville' => "Lens",
            'user_id' => $user->id
        ]);

        $user->save();
        $credentials = ['email' => $user->email, 'password' => 'GrosSecret'];
        $token = JWTAuth::attempt($credentials);
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->getJson('api/clients');

        $response->assertStatus(401);
        $response->assertJson([
            "message" => "Unauthorized",
        ]);
    }
}
