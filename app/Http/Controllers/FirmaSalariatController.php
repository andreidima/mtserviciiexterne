<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Models\FirmaSalariat;
use App\Models\Firma;

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

        return view('firme.salariati.index', compact('salariati', 'search_nume', 'search_firma'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $serviciu = null, Firma $firma)
    {
        $request->session()->put('salariat_return_url', url()->previous());

        return view('firme.salariati.create', compact('serviciu', 'firma'));
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

        return redirect($request->session()->get('salariat_return_url'))->with('status', 'Salariatul „' . ($salariat->nume ?? '') . '” a fost adăugat cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FirmaSalariat  $salariat
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, FirmaSalariat $salariat)
    {
        $request->session()->put('salariat_return_url', url()->previous());

        return view('firme.salariati.show', compact('salariat'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FirmaSalariat  $salariat
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $serviciu = null, Firma $firma, FirmaSalariat $salariat)
    {
        $request->session()->put('salariat_return_url', url()->previous());

        $firme = Firma::orderBy('nume')->get();

        return view('firme.salariati.edit', compact('serviciu', 'firma', 'salariat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FirmaSalariat  $salariat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $serviciu = null, Firma $firma, FirmaSalariat $salariat)
    {
        $request->request->add(['user_id' => $request->user()->id]);
        $salariat->update($this->validateRequest($request));

        return redirect($request->session()->get('salariat_return_url'))->with('status', 'Salariatul „' . ($salariat->nume ?? '') . '” a fost modificat cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FirmaSalariat  $salariat
     * @return \Illuminate\Http\Response
     */
    public function destroy($serviciu = null, Firma $firma, FirmaSalariat $salariat)
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
                'firma_id' => 'nullable|numeric|integer',
                'nume' => 'required|max:500',
                'cnp' => 'nullable|numeric|integer|digits:13',
                'functie' => 'nullable|max:500',
                'data_angajare' => 'nullable|date',
                'data_incetare' => 'nullable|date',
                'instructaj_la_nr_luni' => 'nullable|numeric|integer|between:1,12',
                'data_instructaj' => 'nullable|max:500',
                'anexa_ssm' => 'nullable',
                'lista_eip' => 'nullable',
                'medicina_muncii_examinare' => 'nullable|date',
                'medicina_muncii_expirare' => 'nullable|date',
                'locatie_fisa_ssm' => 'nullable|max:500',
                'locatie_fisa_su' => 'nullable|max:500',
                'observatii' => 'nullable|max:2000',
                'user_id' => 'nullable',
            ],
            [

            ]
        );
    }
}
