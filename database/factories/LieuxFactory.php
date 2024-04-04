<?php

namespace Database\Factories;

use App\Models\Lieux;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class LieuxFactory extends Factory
{

    protected $model = Lieux::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => $this->faker->words(2, true),
            'adresse' => $this->faker->streetAddress(),
            'code_postal' => $this->faker->postcode(),
            'ville' => $this->faker->city(),
            'lat' => $this->faker->latitude(),
            'long' => $this->faker->longitude(),
        ];
    }
}
