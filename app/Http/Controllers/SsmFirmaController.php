<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Models\SsmFirma;
use App\Models\SsmFirmaSalariat;

use Illuminate\Database\Eloquent\Builder;

class SsmFirmaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search_firma = \Request::get('search_firma');
        $search_traseu = \Request::get('search_traseu');
        $search_administrator = \Request::get('search_administrator');
        $search_actionar = \Request::get('search_actionar');
        $search_ssm_luna = \Request::get('search_ssm_luna');
        $search_psi_luna = \Request::get('search_psi_luna');
        $search_perioada = \Request::get('search_perioada');
        $search_contract_firma = \Request::get('search_contract_firma');
        $search_contract_numar = \Request::get('search_contract_numar');
        $search_observatii = \Request::get('search_observatii');

        $firme = SsmFirma::
            when($search_firma, function ($query, $search_firma) {
                return $query->where(function ($query) use ($search_firma) {
                    $query->where('nume', 'like', '%' . $search_firma . '%')
                            ->orwhere('cui', 'like', '%' . $search_firma . '%')
                            ->orwhere('adresa', 'like', '%' . $search_firma . '%')
                            ->orwhere('observatii_1', 'like', '%' . $search_firma . '%')
                            ->orwhere('observatii_2', 'like', '%' . $search_firma . '%')
                            ->orwhere('observatii_3', 'like', '%' . $search_firma . '%');
                            // ->orwhere('j_seap_fact', 'like', '%' . $search_firma . '%');
                });
            })
            ->when($search_traseu, function ($query, $search_traseu) {
                return $query->where('traseu', $search_traseu);
            })
            ->when($search_administrator, function ($query, $search_administrator) {
                return $query->where(function ($query) use ($search_administrator) {
                    $query->where('administrator', 'like', '%' . $search_administrator . '%')
                            ->orwhere('persoana_desemnata', 'like', '%' . $search_administrator . '%');
                });
            })
            ->when($search_actionar, function ($query, $search_actionar) {
                return $query->where('actionar', $search_actionar);
            })
            ->when($search_ssm_luna, function ($query, $search_ssm_luna) {
                return $query->where('ssm_luna', $search_ssm_luna);
            })
            ->when($search_psi_luna, function ($query, $search_psi_luna) {
                return $query->where('psi_luna', $search_psi_luna);
            })
            ->when($search_perioada, function ($query, $search_perioada) {
                return $query->where('perioada', $search_perioada);
            })
            ->when($search_contract_firma, function ($query, $search_contract_firma) {
                return $query->where('contract_firma', 'like', '%' . $search_contract_firma . '%');
            })
            ->when($search_contract_numar, function ($query, $search_contract_numar) {
                return $query->where('contract_numar', 'like', '%' . $search_contract_numar . '%');
            })
            ->when($search_observatii, function ($query, $search_observatii) {
                return $query->where(function ($query) use ($search_observatii) {
                    $query->where('observatii_1', 'like', '%' . $search_observatii . '%')
                            ->orwhere('observatii_2', 'like', '%' . $search_observatii . '%')
                            ->orwhere('observatii_3', 'like', '%' . $search_observatii . '%');
                });
            })
            ->orderBy('nume')
            ->simplePaginate(25);

        $lista_traseu = SsmFirma::select('traseu')->groupBy('traseu')->get();
        $lista_actionar = SsmFirma::select('actionar')->groupBy('actionar')->get();
        $lista_ssm_luna = SsmFirma::select('ssm_luna')->groupBy('ssm_luna')->get();
        $lista_psi_luna = SsmFirma::select('psi_luna')->groupBy('psi_luna')->get();
        $lista_perioada = SsmFirma::select('perioada')->groupBy('perioada')->get();
        $lista_contract_firma = SsmFirma::select('contract_firma')->groupBy('contract_firma')->get();

        $request->session()->forget('firma_return_url');

        return view('ssm.firme.index', compact('firme', 'search_firma', 'search_traseu', 'search_administrator', 'search_actionar', 'search_ssm_luna', 'search_psi_luna', 'search_perioada',
            'search_contract_firma', 'search_contract_numar', 'search_observatii',
            'lista_traseu', 'lista_actionar', 'lista_ssm_luna', 'lista_psi_luna', 'lista_perioada', 'lista_contract_firma'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->session()->get('firma_return_url') ?? $request->session()->put('firma_return_url', url()->previous());

        return view('ssm.firme.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $firma = SsmFirma::create($this->validateRequest($request));

        return redirect($request->session()->get('firma_return_url') ?? ('/ssm/firme'))
            ->with('status', 'Firma „' . ($firma->nume ?? '') . '” a fost adăugată cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SsmFirma  $firma
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, SsmFirma $firma)
    {
        $request->session()->get('firma_return_url') ?? $request->session()->put('firma_return_url', url()->previous());

        return view('ssm.firme.show', compact('firma'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SsmFirma  $firma
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, SsmFirma $firma)
    {
        $request->session()->get('firma_return_url') ?? $request->session()->put('firma_return_url', url()->previous());

        return view('ssm.firme.edit', compact('firma'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SsmFirma  $firma
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SsmFirma $firma)
    {
        // dd($request);
        $firma->update($this->validateRequest($request));

        return redirect($request->session()->get('firma_return_url') ?? ('/ssm/firme'))
            ->with('status', 'Firma „' . ($firma->nume ?? '') . '” a fost modificată cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SsmFirma  $firma
     * @return \Illuminate\Http\Response
     */
    public function destroy(SsmFirma $firma)
    {
        $firma->delete();

        return back()->with('status', 'Firma „' . ($firma->nume ?? '') . '” a fost ștearsă cu succes!');
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
                'nume' => 'required|max:200',
                'cui' => 'nullable|max:200',
                'j_seap_fact' => 'nullable|max:200',
                'adresa' => 'nullable|max:200',
                'doc' => 'nullable|max:200',
                'perioada' => 'nullable|max:200',
                'actionar' => 'nullable|max:200',
                'ssm_luna' => 'nullable|max:200',
                'psi_luna' => 'nullable|max:200',
                'ssm_stare_fise' => 'nullable|max:200',
                'psi_stare_fise' => 'nullable|max:200',
                'administrator' => 'nullable|max:200',
                'persoana_desemnata' => 'nullable|max:200',
                'traseu' => 'nullable|max:200',
                'domeniu_de_activitate' => 'nullable|max:200',
                'pram_zi' => 'nullable|max:200',
                'pram_luna' => 'nullable|max:200',
                'pram_an' => 'nullable|max:200',
                'contract_firma' => 'nullable|max:200',
                'contract_numar' => 'nullable|max:200',
                'contract_semnat' => 'nullable|max:200',
                'observatii_1' => 'nullable|max:1000',
                'observatii_2' => 'nullable|max:1000',
                'observatii_3' => 'nullable|max:1000',
                'observatii_4' => 'nullable|max:1000',
            ],
            [

            ]
        );
    }
}
