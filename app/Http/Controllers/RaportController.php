<?php

namespace App\Http\Controllers;

use App\Models\FirmaStingator;
use App\Models\FirmaSalariat;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class RaportController extends Controller
{
    public function stingatoare_prima_varianta_backup()
    {
        $search_data_inceput = \Request::get('search_data_inceput') ?? Carbon::today();
        $search_data_sfarsit = \Request::get('search_data_sfarsit') ?? Carbon::today()->addDays(5);

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

    public function stingatoare()
    {
        $search_data = \Request::get('search_data') ?
            (Carbon::parse(\Request::get('search_data'))->startOfMonth())
            :
            (Carbon::today()->startOfMonth());

        // dd($search_data->month);

        $stingatoare = FirmaStingator::
            with('firma', 'firma.traseu')
            ->whereMonth('stingatoare_expirare', $search_data->month)
            ->whereYear('stingatoare_expirare', $search_data->year)
            // ->take(10)
            ->get();

        $search_data_luna_precedenta = Carbon::parse($search_data)->subMonth();
        $stingatoare_luna_precedenta = FirmaStingator::
            with('firma', 'firma.traseu')
            ->whereMonth('stingatoare_expirare', $search_data_luna_precedenta->month)
            ->whereYear('stingatoare_expirare', $search_data_luna_precedenta->year)
            // ->take(10)
            ->get();

            // dd($stingatoare);

        return view('rapoarte.stingatoare', compact('stingatoare', 'search_data', 'stingatoare_luna_precedenta', 'search_data_luna_precedenta'));
    }

    public function instructaj()
    {
        $search_data_inceput = \Request::get('search_data_inceput') ?? Carbon::today();
        $search_data_sfarsit = \Request::get('search_data_sfarsit') ?? Carbon::today()->addDays(5);

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
                DB::raw('DATE_ADD(firme_salariati.data_instructaj, INTERVAL +(firme_salariati.instructaj_la_nr_luni) MONTH) AS data_expirare')
            )
            // ->whereBetween('data_expirare', [$search_data_inceput, $search_data_sfarsit])
            ->whereBetween(DB::raw('DATE_ADD(firme_salariati.data_instructaj, INTERVAL +(firme_salariati.instructaj_la_nr_luni) MONTH)'), [$search_data_inceput, $search_data_sfarsit])
            ->get();

        // foreach ($salariati as $salariat){
        //     echo $salariat->nume;
        //     echo '<br>';
        //     echo $salariat->data_instructaj;
        //     echo '<br>';
        //     echo $salariat->instructaj_la_nr_luni;
        //     echo '<br>';
        //     echo $salariat->data_expirare;
        //     echo '<br><br><br>';
        // }

        return view('rapoarte.instructaj', compact('salariati', 'search_data_inceput', 'search_data_sfarsit'));
    }

    public function medicinaMuncii()
    {
        $search_data_inceput = \Request::get('search_data_inceput') ?? Carbon::today();
        $search_data_sfarsit = \Request::get('search_data_sfarsit') ?? Carbon::today()->addDays(5);

        $salariati = FirmaSalariat::
            with('firma:id,nume,traseu_id', 'firma.traseu')
            ->join('firme', 'firme_salariati.firma_id', '=', 'firme.id')
            ->select(
                'firme_salariati.id',
                'firme_salariati.firma_id',
                'firme_salariati.nume',
                'firme_salariati.medicina_muncii_expirare',
                'firme.traseu_id as traseu_id',
            )
            ->whereBetween('medicina_muncii_expirare', [$search_data_inceput, $search_data_sfarsit])
            ->get();

        // foreach ($salariati as $salariat){
        //     echo $salariat->nume;
        //     echo '<br>';
        //     echo $salariat->data_instructaj;
        //     echo '<br>';
        //     echo $salariat->instructaj_la_nr_luni;
        //     echo '<br>';
        //     echo $salariat->data_expirare;
        //     echo '<br><br><br>';
        // }

        return view('rapoarte.medicinaMuncii', compact('salariati', 'search_data_inceput', 'search_data_sfarsit'));
    }
}
