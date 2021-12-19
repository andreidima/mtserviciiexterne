<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Models\Firma;
use App\Models\FirmaSalariat;
use App\Models\FirmaStingator;
use App\Models\FirmaTraseu;
use App\Models\FirmaDomeniuDeActivitate;

class FirmaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_nume = \Request::get('search_nume');

        $firme = Firma::with('stingator')
            ->when($search_nume, function ($query, $search_nume) {
                return $query->where('nume', 'like', '%' . $search_nume . '%');
            })
            ->latest()
            ->simplePaginate(25);

        return view('firme.index', compact('firme', 'search_nume'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $domenii_de_activitate = FirmaDomeniuDeActivitate::orderBy('nume')->get();
        $trasee = FirmaTraseu::orderBy('nume')->get();

        return view('firme.create', compact('domenii_de_activitate', 'trasee'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->request->add(['user_id' => $request->user()->id]);
        $firma = Firma::create($this->validateRequest($request));

        return redirect('/firme')->with('status', 'Firma „' . ($firma->nume ?? '') . '” a fost adăugată cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Firma  $firma
     * @return \Illuminate\Http\Response
     */
    public function show(Firma $firma)
    {
        return view('firme.show', compact('firma'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Firma  $firma
     * @return \Illuminate\Http\Response
     */
    public function edit(Firma $firma)
    {
        $domenii_de_activitate = FirmaDomeniuDeActivitate::orderBy('nume')->get();
        $trasee = FirmaTraseu::orderBy('nume')->get();

        return view('firme.edit', compact('firma', 'domenii_de_activitate', 'trasee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Firma  $firma
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Firma $firma)
    {
        $request->request->add(['user_id' => $request->user()->id]);
        $firma->update($this->validateRequest($request));

        return redirect('/firme')->with('status', 'Firma „' . ($firma->nume ?? '') . '” a fost modificată cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Firma  $firma
     * @return \Illuminate\Http\Response
     */
    public function destroy(Firma $firma)
    {
        if (count($firma->salariati)){
            return back()->with('error', 'Firma „' . ($firma->nume ?? '') . '” nu poate fi ștearsă pentru că are salariați adăugați. Ștergeți mai întâi salariații firmei');
        } else if (count($firma->stingator)){
            return back()->with('error', 'Firma „' . ($firma->nume ?? '') . '” nu poate fi ștearsă pentru că are stingătoare adăugate. Ștergeți mai întâi stingătoarele firmei');
        }

        $firma->delete();

        return redirect('/firme')->with('status', 'Firma „' . ($firma->nume ?? '') . '” a fost ștearsă cu succes!');
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
                'nume' => 'required|max:500',
                'cod_fiscal' => 'nullable|max:500',
                'domeniu_de_activitate_id' => 'nullable|numeric|integer',
                'telefon' => 'nullable|max:500',
                'adresa' => 'nullable|max:500',
                'localitate' => 'nullable|max:500',
                'judet' => 'nullable|max:500',
                'email' => 'nullable|max:500',
                'buletin_pram_expirare' => 'nullable|date',
                'nume_administrator' => 'nullable|max:500',
                'angajat_desemnat' => 'nullable|max:500',
                'observatii' => 'nullable|max:2000',
                'user_id' => 'required',
                'traseu_id' => 'nullable|numeric|integer',
                'traseu_ordine' => 'nullable|numeric|integer'
            ],
            [

            ]
        );
    }
}
