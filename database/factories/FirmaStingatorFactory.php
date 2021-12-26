<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FirmaStingatorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // 'firma_id' => \App\Models\Firma::whereDoesntHave('stingator')->inRandomOrder()->first()->id,
            'p1' => $this->faker->numberBetween(0, 10),
            'p2' => $this->faker->numberBetween(0, 10),
            'p3' => $this->faker->numberBetween(0, 10),
            'p6' => $this->faker->numberBetween(0, 10),
            'p9' => $this->faker->numberBetween(0, 10),
            'sm6' => $this->faker->numberBetween(0, 10),
            'sm9' => $this->faker->numberBetween(0, 10),
            'p50' => $this->faker->numberBetween(0, 10),
            'p100' => $this->faker->numberBetween(0, 10),
            'sm50' => $this->faker->numberBetween(0, 10),
            'sm100' => $this->faker->numberBetween(0, 10),
            'g2' => $this->faker->numberBetween(0, 10),
            'g5' => $this->faker->numberBetween(0, 10),
            'p1' => $this->faker->numberBetween(0, 10),
            'stingatoare_expirare' => $this->faker->dateTimeBetween('+2 days', '+1 month')->format('Y-m-d'),
            'hidranti_expirare' => $this->faker->dateTimeBetween('+2 days', '+1 month')->format('Y-m-d'),
            'observatii' => $this->faker->sentence(),
            'user_id' => '1'
        ];
    }
}
