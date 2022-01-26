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

        $stingatoare = FirmaStingator::
            with('firma', 'firma.traseu')
            ->leftJoin('firme', 'firme.id', '=', 'firme_stingatoare.firma_id')
            ->leftJoin('firme_trasee', 'firme_trasee.id', '=', 'firme.traseu_id')
            ->select(
                'firme_stingatoare.*',
                'firme_trasee.nume as traseu_nume',
            )
            ->whereMonth('stingatoare_expirare', $search_data->month)
            ->whereYear('stingatoare_expirare', $search_data->year)
            ->orderBy('traseu_nume', 'asc')
            ->get();

        $search_data_luna_precedenta = Carbon::parse($search_data)->subMonth();
        $stingatoare_luna_precedenta = FirmaStingator::
            with('firma', 'firma.traseu')
            ->whereMonth('stingatoare_expirare', $search_data_luna_precedenta->month)
            ->whereYear('stingatoare_expirare', $search_data_luna_precedenta->year)
            ->get();

        return view('rapoarte.stingatoare.stingatoare', compact('stingatoare', 'search_data', 'stingatoare_luna_precedenta', 'search_data_luna_precedenta'));
    }

    public function stingatoareExportPDF(Request $request, $search_data = null, $view_type = null)
    {
        $search_data = Carbon::parse($search_data);

        $stingatoare = FirmaStingator::
            with('firma', 'firma.traseu')
            ->leftJoin('firme', 'firme.id', '=', 'firme_stingatoare.firma_id')
            ->leftJoin('firme_trasee', 'firme_trasee.id', '=', 'firme.traseu_id')
            ->select(
                'firme_stingatoare.*',
                'firme_trasee.nume as traseu_nume',
            )
            ->whereMonth('stingatoare_expirare', $search_data->month)
            ->whereYear('stingatoare_expirare', $search_data->year)
            ->orderBy('traseu_nume', 'asc')
            ->get();

        if ($request->view_type === 'export-html') {
            return view('rapoarte.stingatoare.export.stingatoarePdf', compact('stingatoare', 'search_data'));
        } elseif ($request->view_type === 'export-pdf') {
            $pdf = \PDF::loadView('rapoarte.stingatoare.export.stingatoarePdf', compact('stingatoare', 'search_data'))
                ->setPaper('a4', 'portrait');
            $pdf->getDomPDF()->set_option("enable_php", true);
            return $pdf->download('Raport stingatoare pe luna ' . \Carbon\Carbon::parse($search_data)->isoFormat('MM.YYYY') . '.pdf');
            // return $pdf->stream();
        }
    }

    public function hidranti()
    {
        $search_data = \Request::get('search_data') ?
            (Carbon::parse(\Request::get('search_data'))->startOfMonth())
            :
            (Carbon::today()->startOfMonth());

        $hidranti = FirmaStingator::
            with('firma', 'firma.traseu')
            ->leftJoin('firme', 'firme.id', '=', 'firme_stingatoare.firma_id')
            ->leftJoin('firme_trasee', 'firme_trasee.id', '=', 'firme.traseu_id')
            ->select(
                'firme_stingatoare.*',
                'firme_trasee.nume as traseu_nume',
            )
            ->whereMonth('hidranti_expirare', $search_data->month)
            ->whereYear('hidranti_expirare', $search_data->year)
            ->orderBy('traseu_nume', 'asc')
            ->get();

        $search_data_luna_precedenta = Carbon::parse($search_data)->subMonth();
        $hidranti_luna_precedenta = FirmaStingator::
            with('firma', 'firma.traseu')
            ->whereMonth('hidranti_expirare', $search_data_luna_precedenta->month)
            ->whereYear('hidranti_expirare', $search_data_luna_precedenta->year)
            ->get();

        return view('rapoarte.hidranti.hidranti', compact('hidranti', 'search_data', 'hidranti_luna_precedenta', 'search_data_luna_precedenta'));
    }

    public function hidrantiExportPDF(Request $request, $search_data = null, $view_type = null)
    {
        $search_data = Carbon::parse($search_data);

        $hidranti = FirmaStingator::
            with('firma', 'firma.traseu')
            ->leftJoin('firme', 'firme.id', '=', 'firme_stingatoare.firma_id')
            ->leftJoin('firme_trasee', 'firme_trasee.id', '=', 'firme.traseu_id')
            ->select(
                'firme_stingatoare.*',
                'firme_trasee.nume as traseu_nume',
            )
            ->whereMonth('hidranti_expirare', $search_data->month)
            ->whereYear('hidranti_expirare', $search_data->year)
            ->orderBy('traseu_nume', 'asc')
            ->get();

        if ($request->view_type === 'export-html') {
            return view('rapoarte.hidranti.export.hidrantiPdf', compact('hidranti', 'search_data'));
        } elseif ($request->view_type === 'export-pdf') {
            $pdf = \PDF::loadView('rapoarte.hidranti.export.hidrantiPdf', compact('hidranti', 'search_data'))
                ->setPaper('a4', 'portrait');
            $pdf->getDomPDF()->set_option("enable_php", true);
            return $pdf->download('Raport hidranti pe luna ' . \Carbon\Carbon::parse($search_data)->isoFormat('MM.YYYY') . '.pdf');
            // return $pdf->stream();
        }
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
