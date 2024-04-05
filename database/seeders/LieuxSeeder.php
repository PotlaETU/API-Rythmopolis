<?php

namespace Database\Seeders;

use App\Models\Lieux;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LieuxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Lieux::factory(20)->create();
    }
}
