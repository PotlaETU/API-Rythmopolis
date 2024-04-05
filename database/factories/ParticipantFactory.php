<?php

namespace Database\Factories;

use App\Models\Artiste;
use App\Models\Evenement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ParticipantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'evenement_id' => $this->faker->randomElement(Evenement::all())->first(),
            'artiste_id' => $this->faker->randomElement(Artiste::all())->first()
        ];
    }
}
