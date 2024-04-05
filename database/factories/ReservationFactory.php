<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Evenement;
use App\Models\Statut;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date_res' => $this->faker->dateTimeBetween('-3 months', '+3months'),
            'nb_billets' => $this->faker->numberBetween(1, 10),
            'montant' => $this->faker->randomFloat(2, 10, 1000),
            'statut' => $this->faker->randomElement(Statut::STATUTS),
            'evenement_id' => Evenement::all()->random()->id,
            'client_id' => Client::all()->random()->id,
        ];
    }
}
