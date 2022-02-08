<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FirmaSalariat;

use Carbon\Carbon;

class MedicinaMunciiController extends Controller
{
    public function numarInregistare(){
        $search_data = \Request::get('search_data') ?? Carbon::now();
        $search_data = Carbon::parse($search_data)->endOfDay();

        // echo $search_data . '<br>';

        $cel_mai_mare_numar_de_inregistrare =
            FirmaSalariat::whereDate('medicina_muncii_examinare', '<', $search_data)
                ->max('medicina_muncii_nr_inregistrare');

        $salariat = FirmaSalariat::where('medicina_muncii_nr_inregistrare', $cel_mai_mare_numar_de_inregistrare)->first();

        return view('rapoarte.medicinaMuncii.numarDeInregistrare', compact('search_data', 'salariat'));
    }
}
