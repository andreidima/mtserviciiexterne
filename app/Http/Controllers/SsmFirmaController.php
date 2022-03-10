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
        $search_cod_fiscal = \Request::get('search_cod_fiscal');
        $search_ssm_luna = \Request::get('search_ssm_luna');
        $search_psi_luna = \Request::get('search_psi_luna');

        $firme = SsmFirma::
            when($search_firma, function ($query, $search_firma) {
                return $query->where('nume', 'like', '%' . $search_firma . '%');
            })
            ->when($search_cod_fiscal, function ($query, $search_cod_fiscal) {
                return $query->where('cod_fiscal', 'like', '%' . $search_cod_fiscal . '%');
            })
            ->when($search_ssm_luna, function ($query, $search_ssm_luna) {
                return $query->where('ssm_luna', 'like', '%' . $search_ssm_luna . '%');
            })
            ->when($search_psi_luna, function ($query, $search_psi_luna) {
                return $query->where('psi_luna', 'like', '%' . $search_psi_luna . '%');
            })
            ->latest()
            ->simplePaginate(100);

        $lista_ssm_luna = SsmFirma::select('ssm_luna')->groupBy('ssm_luna')->get();
        $lista_psi_luna = SsmFirma::select('psi_luna')->groupBy('psi_luna')->get();

        $request->session()->forget('firma_return_url');

        return view('ssm.firme.index', compact('firme', 'search_firma', 'search_cod_fiscal', 'search_ssm_luna', 'search_psi_luna',
            'lista_ssm_luna', 'lista_psi_luna'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $serviciu = null)
    {
        $domenii_de_activitate = FirmaDomeniuDeActivitate::orderBy('nume')->get();
        $trasee = FirmaTraseu::
            where (function($query) use ($serviciu) {
                switch ($serviciu) {
                    case 'ssm':
                        $query->where('serviciu', 1);
                        break;
                    case 'stingatoare':
                        $query->where('serviciu', 2);
                        break;
                    default:
                        # code...
                        break;
                }
            })
            ->orderBy('nume')->get();

        $request->session()->get('firma_return_url') ?? $request->session()->put('firma_return_url', url()->previous());

        return view('firme.create', compact('domenii_de_activitate', 'trasee', 'serviciu'));
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
        $firma = Firma::create($this->validateRequest($request, $serviciu));

        return redirect($request->session()->get('firma_return_url') ?? ('/' . $serviciu . '/firme'))
            ->with('status', 'Firma „' . ($firma->nume ?? '') . '” a fost adăugată cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Firma  $firma
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $serviciu = null, Firma $firma)
    {
        $request->session()->get('firma_return_url') ?? $request->session()->put('firma_return_url', url()->previous());

        return view('firme.show', compact('firma', 'serviciu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Firma  $firma
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $serviciu = null, Firma $firma)
    {
        $domenii_de_activitate = FirmaDomeniuDeActivitate::orderBy('nume')->get();
        $trasee = FirmaTraseu::
            where (function($query) use ($serviciu) {
                switch ($serviciu) {
                    case 'ssm':
                        $query->where('serviciu', 1);
                        break;
                    case 'stingatoare':
                        $query->where('serviciu', 2);
                        break;
                    default:
                        # code...
                        break;
                }
            })
            ->orderBy('nume')->get();

        $request->session()->get('firma_return_url') ?? $request->session()->put('firma_return_url', url()->previous());

        return view('firme.edit', compact('firma', 'domenii_de_activitate', 'trasee', 'serviciu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Firma  $firma
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $serviciu = null, Firma $firma)
    {
        $request->request->add(['user_id' => $request->user()->id]);
        $firma->update($this->validateRequest($request, $serviciu));

        return redirect($request->session()->get('firma_return_url') ?? ('/' . $serviciu . '/firme'))
            ->with('status', 'Firma „' . ($firma->nume ?? '') . '” a fost modificată cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Firma  $firma
     * @return \Illuminate\Http\Response
     */
    public function destroy($serviciu = null, Firma $firma)
    {
        if (count($firma->salariati)){
            return back()->with('error', 'Firma „' . ($firma->nume ?? '') . '” nu poate fi ștearsă pentru că are salariați adăugați. Ștergeți mai întâi salariații firmei');
        } else if ($firma->stingator){
            return back()->with('error', 'Firma „' . ($firma->nume ?? '') . '” nu poate fi ștearsă pentru că are stingătoare adăugate. Ștergeți mai întâi stingătoarele firmei');
        }

        $firma->delete();

        return back()->with('status', 'Firma „' . ($firma->nume ?? '') . '” a fost ștearsă cu succes!');
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest(Request $request, $serviciu = null)
    {
        switch ($serviciu) {
            case 'ssm':
                $request->request->add(['ssm_serviciu' => 1]);
                break;
            case 'medicina-muncii':
                $request->request->add(['medicina_muncii_serviciu' => 1]);
                break;
            case 'stingatoare':
                $request->request->add(['stingatoare_serviciu' => 1]);
                break;
            default:
                # code...
                break;
            }

        return $request->validate(
            [
                'nume' => 'required|max:500',
                'cod_fiscal' => 'nullable|max:500',
                'domeniu_de_activitate_id' => 'nullable|numeric|integer',
                'telefon' => 'nullable|max:500',
                'adresa' => 'nullable|max:500',
                'localitate' => 'nullable|max:500',
                'judet' => 'nullable|max:500',
                'email' => 'nullable|max:500|email:rfc,dns',
                'buletin_pram_expirare' => 'nullable|date',
                'nume_administrator' => 'nullable|max:500',
                'angajat_desemnat' => 'nullable|max:500',
                'iscir' => 'nullable',
                'iscir_descriere' => 'nullable|max:2000',
                'contract_firma' => 'nullable|max:500',
                'contract_numar' => 'nullable|max:500',
                'contract_valoare' => 'nullable|max:500',
                'documentatie' => 'nullable|max:2000',
                'observatii' => 'nullable|max:2000',
                'user_id' => 'nullable',
                'actionar' => 'nullable',
                'traseu_id' => 'nullable|numeric|integer',
                // 'traseu_ordine' => 'nullable|numeric|integer',
                'ssm_serviciu' => '',
                'medicina_muncii_serviciu' => '',
                'stingatoare_serviciu' => ''
            ],
            [

            ]
        );
    }
}
