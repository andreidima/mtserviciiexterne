<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FirmaSalariat;

use Carbon\Carbon;

class MedicinaMunciiController extends Controller
{
    public function numarInregistare(){
        $cel_mai_mare_numar_de_inregistrare = FirmaSalariat::max('medicina_muncii_nr_inregistrare');
        $cel_mai_mare_numar_de_inregistrare_luna_anterioara =
            FirmaSalariat::whereDate('medicina_muncii_examinare', '<', Carbon::today()->subMonthsNoOverflow(1)->endOfMonth())
                ->max('medicina_muncii_nr_inregistrare');
        $cel_mai_mare_numar_de_inregistrare_acum_2_luni =
            FirmaSalariat::whereDate('medicina_muncii_examinare', '<', Carbon::today()->subMonthsNoOverflow(2)->endOfMonth())
                ->max('medicina_muncii_nr_inregistrare');
        $cel_mai_mare_numar_de_inregistrare_acum_3_luni =
            FirmaSalariat::whereDate('medicina_muncii_examinare', '<', Carbon::today()->subMonthsNoOverflow(3)->endOfMonth())
                ->max('medicina_muncii_nr_inregistrare');
        $cel_mai_mare_numar_de_inregistrare_acum_4_luni =
            FirmaSalariat::whereDate('medicina_muncii_examinare', '<', Carbon::today()->subMonthsNoOverflow(4)->endOfMonth())
                ->max('medicina_muncii_nr_inregistrare');
        echo $cel_mai_mare_numar_de_inregistrare . '<br>';
        echo $cel_mai_mare_numar_de_inregistrare_luna_anterioara . '<br>';
        echo $cel_mai_mare_numar_de_inregistrare_acum_2_luni . '<br>';
        echo $cel_mai_mare_numar_de_inregistrare_acum_3_luni . '<br>';
        echo $cel_mai_mare_numar_de_inregistrare_acum_4_luni . '<br>';
    }
}
