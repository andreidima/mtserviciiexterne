<?php

namespace App\Http\Controllers;

use App\Models\FirmaStingator;
use App\Models\FirmaSalariat;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class RaportController extends Controller
{
    public function raportStingatoare()
    {
        $search_data_inceput = \Request::get('search_data_inceput') ?? \Carbon\Carbon::today();
        $search_data_sfarsit = \Request::get('search_data_sfarsit') ?? \Carbon\Carbon::today()->addDays(5);

        $stingatoare_nesortate = FirmaStingator::
            with('firma:id,nume,traseu_id', 'firma.traseu')
            ->join('firme', 'firme_stingatoare.firma_id', '=', 'firme.id')
            ->select('firme_stingatoare.id', 'firme_stingatoare.firma_id', 'firme_stingatoare.stingatoare_expirare', 'firme_stingatoare.hidranti_expirare',
                'firme.traseu_id as traseu_id')
            ->whereBetween('stingatoare_expirare', [$search_data_inceput, $search_data_sfarsit])
            ->orWhereBetween('hidranti_expirare', [$search_data_inceput, $search_data_sfarsit])
            ->get();

        foreach ($stingatoare_nesortate as $stingator){
            if (($stingator->stingatoare_expirare < $search_data_inceput) || ($stingator->stingatoare_expirare > $search_data_sfarsit)) {
                $stingator->stingatoare_expirare = '';
                $stingator->data_expirare = $stingator->hidranti_expirare;
            } else if (($stingator->hidranti_expirare < $search_data_inceput) || ($stingator->hidranti_expirare > $search_data_sfarsit)) {
                $stingator->hidranti_expirare = '';
                $stingator->data_expirare = $stingator->stingatoare_expirare;
            }

            if (!empty($stingator->stingatoare_expirare) && !empty($stingator->hidranti_expirare)){
                if ($stingator->stingatoare_expirare < $stingator->hidranti_expirare) {
                    $stingator->data_expirare = $stingator->stingatoare_expirare;
                } else {
                    $stingator->data_expirare = $stingator->hidranti_expirare;
                }
            }

            // echo $stingator->firma_id;
            // echo '<br>';
            // echo $stingator->stingatoare_expirare . ' - stingatoare';
            // echo '<br>';
            // echo $stingator->hidranti_expirare . ' - hidranti';
            // echo '<br>';
            // echo $stingator->data_expirare . ' - data';
            // echo '<br>';
            // echo '<br>';
        }

// dd($stingatoare_nesortate);

        // $stingatoare->sortBy('data_expirare');
        $stingatoare = $stingatoare_nesortate->sortBy('data_expirare');
        $stingatoare->values()->all();
        // $stingatoare->sortByDesc('id');
// dd($stingatoare);
        return view('rapoarte.stingatoare', compact('stingatoare', 'search_data_inceput', 'search_data_sfarsit'));
    }

    public function raportInstructaj()
    {
        $search_data_inceput = \Request::get('search_data_inceput') ?? \Carbon\Carbon::today();
        $search_data_sfarsit = \Request::get('search_data_sfarsit') ?? \Carbon\Carbon::today()->addDays(5);

        $salariati = FirmaSalariat::
            with('firma:id,nume,traseu_id', 'firma.traseu')
            ->join('firme', 'firme_salariati.firma_id', '=', 'firme.id')
            ->select(
                'firme_salariati.id',
                'firme_salariati.firma_id',
                'firme_salariati.nume',
                'firme_salariati.data_instructaj',
                'firme_salariati.instructaj_la_nr_luni',
                'firme.traseu_id as traseu_id',
                DB::raw('DATE_ADD(firme_salariati.data_instructaj, INTERVAL -(firme_salariati.instructaj_la_nr_luni) MONTH) AS DateAdd')
            )
            // ->whereBetween('data_instructaj', [$search_data_inceput, $search_data_sfarsit])
            ->get();

        foreach ($salariati as $salariat){
            echo $salariat->nume;
            echo '<br>';
            echo $salariat->data_instructaj;
            echo '<br>';
            echo $salariat->instructaj_la_nr_luni;
            echo '<br>';
            echo $salariat->DateAdd;
            echo '<br><br><br>';
        }

        dd('stop');
    }
}
