<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(TypeSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(ArtistesSeeder::class);
        $this->call(ClientSeeder::class);
        $this->call(EvenementSeeder::class);
        $this->call(ReservationSeeder::class);
        $this->call(PrixSeeder::class);
    }
}
