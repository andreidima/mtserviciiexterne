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
        $search_firma_si_cui = \Request::get('search_firma_si_cui');
        $search_adresa_si_observatii = \Request::get('search_adresa_si_observatii');
        $search_traseu = \Request::get('search_traseu');
        $search_administrator_si_pers_desemnata = \Request::get('search_administrator_si_pers_desemnata');
        $search_domeniu_de_activitate = \Request::get('search_domeniu_de_activitate');
        $search_actionar = \Request::get('search_actionar');
        $search_tip = \Request::get('search_tip');
        $search_ssm_luna = \Request::get('search_ssm_luna');
        $search_psi_luna = \Request::get('search_psi_luna');
        $search_perioada = \Request::get('search_perioada');
        $search_contract_firma = \Request::get('search_contract_firma');
        $search_contract_numar = \Request::get('search_contract_numar');
        $search_observatii = \Request::get('search_observatii');
        $searchActiva = \Request::get('searchActiva') ?? 1;

        $firme = SsmFirma::
            when($search_firma_si_cui, function ($query, $search_firma_si_cui) {
                return $query->where(function ($query) use ($search_firma_si_cui) {
                    $query->where('nume', 'like', '%' . $search_firma_si_cui . '%')
                            ->orwhere('cui', 'like', '%' . $search_firma_si_cui . '%');
                });
            })
            ->when($search_adresa_si_observatii, function ($query, $search_adresa_si_observatii) {
                return $query->where(function ($query) use ($search_adresa_si_observatii) {
                    $query->where('adresa', 'like', '%' . $search_adresa_si_observatii . '%')
                            ->orwhere('observatii_1', 'like', '%' . $search_adresa_si_observatii . '%')
                            ->orwhere('observatii_2', 'like', '%' . $search_adresa_si_observatii . '%')
                            ->orwhere('observatii_3', 'like', '%' . $search_adresa_si_observatii . '%');
                });
            })
            ->when($search_traseu, function ($query, $search_traseu) {
                return $query->where('traseu', $search_traseu);
            })
            ->when($search_administrator_si_pers_desemnata, function ($query, $search_administrator_si_pers_desemnata) {
                return $query->where(function ($query) use ($search_administrator_si_pers_desemnata) {
                    $query->where('administrator', 'like', '%' . $search_administrator_si_pers_desemnata . '%')
                            ->orwhere('persoana_desemnata', 'like', '%' . $search_administrator_si_pers_desemnata . '%');
                });
            })
            ->when($search_domeniu_de_activitate, function ($query, $search_domeniu_de_activitate) {
                return $query->where('domeniu_de_activitate', 'like', '%' . $search_domeniu_de_activitate . '%');
            })
            ->when($search_actionar, function ($query, $search_actionar) {
                return $query->where('actionar', $search_actionar);
            })
            ->when($search_tip, function ($query, $search_tip) {
                return $query->where('tip', $search_tip);
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
            ->where('activa', $searchActiva)
            ->orderBy('nume');

        if ($request->input('action') === 'exportPdf') {
            $firme = $firme->get();
            if ($firme->count() > 500) {
                return back()->with('error', 'Nu se pot extrage mai mult de 500 firme odată. Filtrați datele pentru a limita numărul de firme.');
            }
            $pdf = \PDF::loadView('ssm.rapoarte.export.firmePdf', compact('firme', 'search_ssm_luna', 'search_psi_luna'))
                ->setPaper('a4', 'portrait');
            $pdf->getDomPDF()->set_option("enable_php", true);
            return $pdf->download('Raport SSM - firme.pdf');
            // return $pdf->stream();
        }

        $firme = $firme->simplePaginate(25);

        $lista_traseu = SsmFirma::select('traseu')->groupBy('traseu')->orderBy('traseu')->get();
        $lista_actionar = SsmFirma::select('actionar')->groupBy('actionar')->get();
        $lista_tip = SsmFirma::select('tip')->groupBy('tip')->get();
        $lista_ssm_luna = SsmFirma::select('ssm_luna')->groupBy('ssm_luna')->get();
        $lista_psi_luna = SsmFirma::select('psi_luna')->groupBy('psi_luna')->get();
        $lista_perioada = SsmFirma::select('perioada')->groupBy('perioada')->get();
        $lista_contract_firma = SsmFirma::select('contract_firma')->groupBy('contract_firma')->get();

        $request->session()->forget('firma_return_url');

        return view('ssm.firme.index', compact('firme', 'search_firma_si_cui', 'search_adresa_si_observatii', 'search_traseu', 'search_administrator_si_pers_desemnata', 'search_domeniu_de_activitate',
            'search_actionar', 'search_tip', 'search_ssm_luna', 'search_psi_luna', 'search_perioada',
            'search_contract_firma', 'search_contract_numar', 'search_observatii',
            'lista_traseu', 'lista_actionar', 'lista_tip', 'lista_ssm_luna', 'lista_psi_luna', 'lista_perioada', 'lista_contract_firma', 'searchActiva'
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
                'tip' => 'nullable|max:200',
                'ssm_luna' => 'nullable|max:200',
                'psi_luna' => 'nullable|max:200',
                'ssm_stare_fise' => 'nullable|max:200',
                'psi_stare_fise' => 'nullable|max:200',
                'administrator' => 'nullable|max:200',
                'persoana_desemnata' => 'nullable|max:200',
                'traseu' => 'nullable|max:200',
                'domeniu_de_activitate' => 'nullable|max:200',
                'pram' => 'nullable|max:200',
                // 'pram_zi' => 'nullable|max:200',
                // 'pram_luna' => 'nullable|max:200',
                // 'pram_an' => 'nullable|max:200',
                'contract_firma' => 'nullable|max:200',
                'contract_numar' => 'nullable|max:200',
                'contract_semnat' => 'nullable|max:200',
                'observatii_1' => 'nullable|max:1000',
                'observatii_2' => 'nullable|max:1000',
                'observatii_3' => 'nullable|max:1000',
                'observatii_4' => 'nullable|max:1000',
                'activa' => 'nullable|max:200',
            ],
            [

            ]
        );
    }

    public function axiosModificareFirmeDirectDinIndex(Request $request)
    {
        $firma = SsmFirma::where('id', $request->firmaId)->update([$request->camp => $request->valoare]);

        return response()->json([
            'raspuns' => "Actualizat",
            'firmaId' => $request->firmaId,
            'camp' => $request->camp,
        ]);
    }

    public function duplica(Request $request, SsmFirma $firma)
    {
        $firma = $firma->replicate(['created_at', 'updated_at']);

        $firma->nume = $firma->nume . ' DUPLICAT';

        $firma->save();

        $request->session()->get('firma_return_url') ?? $request->session()->put('firma_return_url', url()->previous());

        return view('ssm.firme.edit', compact('firma'));
    }
}
