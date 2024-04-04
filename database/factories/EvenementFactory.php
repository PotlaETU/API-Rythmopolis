<?php

namespace Database\Factories;

use App\Models\Lieux;
use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Evenement>
 */
class EvenementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titre' => $this->faker->randomElement(Type::TYPES),
            'description' => $this->faker->paragraph(),
            'date_event' => $this->faker->dateTimeBetween('-3 months', '+3months'),
            'lieu_id' => Lieux::factory(),
        ];
    }
}
