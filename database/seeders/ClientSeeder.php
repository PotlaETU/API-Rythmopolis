<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleAdmin = Role::where('nom', Role::ADMIN)->first();
        $roleActif = Role::where('nom', Role::ACTIF)->first();

        $robert = User::create([
            'name' => "Robert Duchmol",
            'email' => "robert.duchmol@domain.fr",
            'email_verified_at' => now(),
            'password' => Hash::make('GrosSecret'),
            'remember_token' => Str::random(10),
        ]);
        Client::factory()->create([
            'nom' => "Duchmol",
            'prenom' => "Robert",
            'avatar' => "https://randomuser.me/api/port",
            'adresse' => "Rue de l'Université",
            'code_postal' => "62300",
            'ville' => "Lens",
            'user_id' => $robert->id
        ]);
        $robert->roles()->attach([$roleAdmin->id, $roleActif->id]);
        $robert->save();

        $clients = Client::factory(10)->make();
        foreach ($clients as $client) {
            $user = User::create([
                'name' => $client->prenom . ' ' . $client->nom,
                'email' => $client->prenom . '.' . $client->nom."@domain.fr",
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ]);
            $user->roles()->attach($roleActif->id);
            $client->user_id = $user->id;
            $client->save();
        }
    }
}
