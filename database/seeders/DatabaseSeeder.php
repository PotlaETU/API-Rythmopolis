<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\LieuxFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(ArtistesSeeder::class);
        $this->call(ClientSeeder::class);
        $this->call(LieuxSeeder::class);
        $this->call(EvenementSeeder::class);
        $this->call(PrixSeeder::class);
        $this->call(ReservationSeeder::class);
        $this->call(BilletSeeder::class);
        $this->call(ParticipantSeeder::class);
    }
}
