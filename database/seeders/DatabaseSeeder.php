<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        \App\Models\Firma::factory(90)
            ->state(new Sequence(
                ['localitate' => 'Biliești', 'traseu_id' => 1], ['localitate' => 'Suraia', 'traseu_id' => 1], ['localitate' => 'Vadu Roșca', 'traseu_id' => 1],
                ['localitate' => 'Golești', 'traseu_id' => 2], ['localitate' => 'Cotești', 'traseu_id' => 2], ['localitate' => 'Budești', 'traseu_id' => 2], ['localitate' => 'Urechești', 'traseu_id' => 2],
                ['localitate' => 'Vîlcele', 'traseu_id' => 3], ['localitate' => 'Cîmpineanca', 'traseu_id' => 3], ['localitate' => 'Pietroasa', 'traseu_id' => 3],
                ['localitate' => 'Petrești', 'traseu_id' => 4], ['localitate' => 'Mircești', 'traseu_id' => 4], ['localitate' => 'Balta Raței', 'traseu_id' => 4],
                ['localitate' => 'Garoafa', 'traseu_id' => 5], ['localitate' => 'Bizighești', 'traseu_id' => 5], ['localitate' => 'Mărășești', 'traseu_id' => 5],
                ['localitate' => 'Focșani', 'traseu_id' => 6], ['localitate' => 'Focșani', 'traseu_id' => 6],
                ['localitate' => 'Focșani', 'traseu_id' => 6], ['localitate' => 'Focșani', 'traseu_id' => 6],
            ))
            ->create();
        \App\Models\FirmaSalariat::factory(120)->create();

        $firme = \App\Models\Firma::all();
        foreach($firme as $firma){
            \App\Models\FirmaStingator::factory()->create([
                'firma_id' => $firma->id,
            ]);
        }
    }
}
