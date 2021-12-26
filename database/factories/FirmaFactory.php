<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FirmaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nume' => $this->faker->company(),
            'cod_fiscal' => $this->faker->randomNumber(7, true),
            'domeniu_de_activitate_id' => \App\Models\FirmaDomeniuDeActivitate::inRandomOrder()->first()->id,
            'telefon' => '074' . $this->faker->randomNumber(7, true),
            'adresa' => $this->faker->address(),
            // 'localitate' => $this->faker->randomElement([
            //     'Biliesti', 'Suraia', 'Vadu Roșca',
            //     'Golești', 'Cotești', 'Budești', 'Urechești',
            //     'Vîlcele', 'Cîmpineanca', 'Pietroasa',
            //     'Petrești', 'Mircești', 'Balta Raței',
            //     'Garoafa', 'Bizighești', 'Mărășești',
            //     'Focșani',
            // ]),
            'judet' => 'Vrancea',
            'email' => $this->faker->email(),
            'buletin_pram_expirare' => $this->faker->dateTimeBetween('+1 week', '+2 years')->format('Y-m-d'),
            'nume_administrator' => $this->faker->firstName() . ' ' . $this->faker->lastName(),
            'angajat_desemnat' => $this->faker->firstName() . ' ' . $this->faker->lastName(),
            'user_id' => '1'
        ];
    }
}
