<?php

namespace App\Http\Controllers;

use App\Models\FirmaStingator;
use App\Models\FirmaSalariat;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class StingatorRaportController extends Controller
{
    public function raport()
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

        return view('stingatoare.rapoarte.raport', compact('stingatoare', 'search_data', 'stingatoare_luna_precedenta', 'search_data_luna_precedenta'));
    }

}
