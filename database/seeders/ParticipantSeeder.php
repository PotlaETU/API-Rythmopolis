<?php

namespace Database\Seeders;

use App\Models\Artiste;
use App\Models\Evenement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParticipantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $evenements = Evenement::all();
        $artistes = Artiste::all();

        foreach ($evenements as $evenement) {
            $artistesAleatoires = $artistes->random(rand(1, 3))->pluck('id');
            $evenement->artistes()->attach($artistesAleatoires);
        }
    }
}
