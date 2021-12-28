<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FirmaSalariatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'firma_id' => \App\Models\Firma::inRandomOrder()->first()->id,
            'nume' => $this->faker->firstName() . ' ' . $this->faker->lastName(),
            'cnp' => $this->faker->cnp(),
            'functie' => $this->faker->randomElement(['Contabil', 'Administrator', 'Muncitor', 'Economist', 'Sofer', 'Director Economic']),
            'data_angajare' => $this->faker->dateTimeBetween('-10 years', '-1 week')->format('Y-m-d'),
            // 'data_incetare' => '',
            'instructaj_la_nr_luni' => $this->faker->numberBetween(1, 2),
            'data_instructaj' => $this->faker->dateTimeBetween('-2 months', '-1 month')->format('Y-m-d'),
            'anexa_ssm' => $this->faker->numberBetween(0, 1),
            'lista_eip' => $this->faker->numberBetween(0, 1),
            'medicina_muncii_expirare' => $this->faker->dateTimeBetween('+1 day', '+2 months')->format('Y-m-d'),
            'locatie_fisa_ssm' => $this->faker->numberBetween(0, 1),
            'locatie_fisa_su' => $this->faker->numberBetween(0, 1),
            'user_id' => '1'
        ];
    }
}
