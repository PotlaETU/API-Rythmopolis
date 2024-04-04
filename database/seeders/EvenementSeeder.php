<?php

namespace Database\Seeders;

use App\Models\Evenement;
use Database\Factories\EvenementFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EvenementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Evenement::factory(10)->create();
    }
}
