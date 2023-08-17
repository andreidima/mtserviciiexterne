<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

use App\Models\FirmaSalariat;
use App\Models\Firma;

use \Carbon\Carbon;

use Illuminate\Support\Facades\Validator;

use Illuminate\Database\Eloquent\Builder;

class FirmaSalariatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_nume = \Request::get('search_nume');
        $search_firma = \Request::get('search_firma');

        $salariati = FirmaSalariat::with('firma')
            ->when($search_nume, function ($query, $search_nume) {
                return $query->where('nume', 'like', '%' . $search_nume . '%');
            })
            ->when($search_firma, function (Builder $query) use ($search_firma) {
                $query->whereHas('firma', function (Builder $query) use ($search_firma) {
                    $query->where('nume', 'like', '%' . $search_firma . '%');
                });
            })
            ->latest()
            ->simplePaginate(25);

        $request->session()->forget('salariat_return_url');

        return view('firme.salariati.index', compact('salariati', 'search_nume', 'search_firma'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $serviciu = null, Firma $firma_curenta)
    {
        $firme = Firma::
            where (function($query) use ($serviciu) {
                switch ($serviciu) {
                    case 'ssm':
                        $query
                            ->where('ssm_serviciu', 1)
                            ->where('medicina_muncii_serviciu', 0)
                            ->where('stingatoare_serviciu', 0);
                        break;
                    case 'medicina-muncii':
                        $query
                            ->where('ssm_serviciu', 0)
                            ->where('medicina_muncii_serviciu', 1)
                            ->where('stingatoare_serviciu', 0);
                        break;
                    case 'stingatoare':
                        $query
                            ->where('ssm_serviciu', 0)
                            ->where('medicina_muncii_serviciu', 0)
                            ->where('stingatoare_serviciu', 1);
                        break;
                    default:
                        # code...
                        break;
                }
            })
            ->orderBy('nume')
            ->get();

        $request->session()->get('salariat_return_url') ?? $request->session()->put('salariat_return_url', url()->previous());

        return view('firme.salariati.create', compact('serviciu', 'firme', 'firma_curenta'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $serviciu = null)
    {
        $request->request->add(['user_id' => $request->user()->id]);
        $salariat = FirmaSalariat::create($this->validateRequest($request));

        return redirect($request->session()->get('salariat_return_url') ?? ('/' . $serviciu . '/firme'))
            ->with('status', 'Salariatul „' . ($salariat->nume ?? '') . '” a fost adăugat cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FirmaSalariat  $salariat
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, FirmaSalariat $salariat)
    {
        $request->session()->get('salariat_return_url') ?? $request->session()->put('salariat_return_url', url()->previous());

        return view('firme.salariati.show', compact('salariat'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FirmaSalariat  $salariat
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $serviciu = null, Firma $firma_curenta, FirmaSalariat $salariat)
    {
        $firme = Firma::
            where (function($query) use ($serviciu) {
                switch ($serviciu) {
                    case 'ssm':
                        $query
                            ->where('ssm_serviciu', 1)
                            ->where('medicina_muncii_serviciu', 0)
                            ->where('stingatoare_serviciu', 0);
                        break;
                    case 'medicina-muncii':
                        $query
                            ->where('ssm_serviciu', 0)
                            ->where('medicina_muncii_serviciu', 1)
                            ->where('stingatoare_serviciu', 0);
                        break;
                    case 'stingatoare':
                        $query
                            ->where('ssm_serviciu', 0)
                            ->where('medicina_muncii_serviciu', 0)
                            ->where('stingatoare_serviciu', 1);
                        break;
                    default:
                        # code...
                        break;
                }
            })
            ->orderBy('nume')
            ->get();

        $request->session()->get('salariat_return_url') ?? $request->session()->put('salariat_return_url', url()->previous());

        return view('firme.salariati.edit', compact('serviciu', 'firme', 'firma_curenta', 'salariat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FirmaSalariat  $salariat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $serviciu = null, Firma $firma_curenta, FirmaSalariat $salariat)
    {
        $request->request->add(['user_id' => $request->user()->id]);
        $salariat->update($this->validateRequest($request));

        return redirect($request->session()->get('salariat_return_url') ?? ('/' . $serviciu . '/firme'))
            ->with('status', 'Salariatul „' . ($salariat->nume ?? '') . '” a fost modificat cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FirmaSalariat  $salariat
     * @return \Illuminate\Http\Response
     */
    public function destroy($serviciu = null, Firma $firma_curenta, FirmaSalariat $salariat)
    {
        $salariat->delete();

        return back()->with('status', 'Salariatul „' . ($salariat->nume ?? '') . '” a fost șters cu succes!');
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest(Request $request)
    {
        return $request->validate(
            [
                'firma_id' => 'nullable|integer',
                'nume' => 'required|max:500',
                'cnp' => 'nullable|integer|digits_between:1,13',
                'functie' => 'nullable|max:500',
                'data_angajare' => 'nullable|date',
                'data_incetare' => 'nullable|date',
                'ssm_data_instructaj' => 'nullable|max:500',
                'ssm_instructaj_la_nr_luni' => 'nullable|integer|between:1,12',
                'psi_data_instructaj' => 'nullable|max:500',
                'psi_instructaj_la_nr_luni' => 'nullable|integer|between:1,12',
                'anexa_ssm' => 'nullable',
                'lista_eip' => 'nullable',
                'medicina_muncii_nr_inregistrare' => 'nullable|integer|max:99999999',
                'medicina_muncii_examinare' => 'nullable|date',
                'medicina_muncii_expirare' => 'nullable|date',
                'locatie_fisa_ssm' => 'nullable|max:500',
                'locatie_fisa_su' => 'nullable|max:500',
                'suspendat' => '',
                'activ' => '',
                'observatii' => 'nullable|max:2000',
                'user_id' => 'nullable',
            ],
            [

            ]
        );
    }

    public function axiosModificareSalariatiDirectDinIndex(Request $request)
    {
        if (($request->camp === 'medicina_muncii_examinare') || ($request->camp === 'medicina_muncii_expirare')){
            // try {
            //     Carbon::parse($request->valoare);
            // } catch (\Carbon\Exceptions\InvalidFormatException $e) {
            //     return response()->json([
            //         'mesaj' => "Formatul datei este greșit",
            //         'salariatId' => $request->salariatId,
            //         'camp' => $request->camp,
            //     ]);
            // }

            $validator = Validator::make(['data' => $request->valoare], ['data' => 'date',]);

            if (!$validator->passes()){
                return response()->json([
                    'mesaj' => "Formatul datei este greșit",
                    'salariatId' => $request->salariatId,
                    'camp' => $request->camp,
                ]);
            }

            $request->valoare = Carbon::parse($request->valoare)->isoFormat('YYYY-MM-DD');
        }

        $salariat = FirmaSalariat::where('id', $request->salariatId)->first();
        $salariat->update([$request->camp => $request->valoare]);

        return response()->json([
            'mesaj' => "",
            'salariatId' => $salariat->id,
            'camp' => $request->camp,
        ]);
    }
}
