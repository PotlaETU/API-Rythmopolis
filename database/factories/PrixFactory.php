<?php

namespace Database\Factories;

use App\Models\Evenement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PrixFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'categorie' => $this->faker->randomElement(['Adulte', 'Enfant', 'Senior']),
            'nombre' => $this->faker->numberBetween(50, 200),
            'valeur' => $this->faker->randomFloat(2, 15, 200),
            'evenement_id' => Evenement::all()->random()->id,
        ];
    }
}
