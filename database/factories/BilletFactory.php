<?php

namespace Database\Factories;

use App\Models\Prix;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BilletFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $reservation = Reservation::all()->random();
        $prix = Prix::where('evenement_id', $reservation->evenement_id)->first();
        return [
            'quantite' => $reservation->nb_billets,
            'prix_id' => $prix->id,
            'reservation_id' => $reservation->id,
        ];
    }
}
