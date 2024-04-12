<?php

namespace Database\Seeders;

use App\Models\Artiste;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArtistesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Artiste::factory(10)->create();
    }
}
