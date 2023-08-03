<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

use App\Models\SsmSalariat;

use Illuminate\Database\Eloquent\Builder;

class SsmSalariatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $search_firma = \Request::get('search_firma');
        $searchDataSsmPsi = \Request::get('searchDataSsmPsi');
        $search_firma_nume = \Request::get('search_firma_nume');
        $search_salariat = \Request::get('search_salariat');
        $search_cnp = \Request::get('search_cnp');
        $search_traseu = \Request::get('search_traseu');
        $search_traseu = \Request::get('search_traseu');
        $search_de_rezolvat = \Request::get('search_de_rezolvat');
        $searchDataInc = \Request::get('searchDataInc');
        $searchActionar = \Request::get('searchActionar');
        $searchObservatii = \Request::get('searchObservatii');

        if(isset($_GET['butonSortare'])) {
            $arr = explode(".", $_GET['butonSortare'], 2);
            $campSortare = $arr[0];
            $ordineSortare = $arr[1];
        }
        if (!isset($campSortare)) {
            $campSortare = 'salariat';
            $ordineSortare = 'asc';
        }

        $query = SsmSalariat::
            // when($search_firma, function ($query, $search_firma) {
            //     return $query->where('nume_client', $search_firma);
            // })
            when($searchDataSsmPsi, function ($query, $searchDataSsmPsi) {
                return $query->where('data_ssm_psi', 'like', '%' . $searchDataSsmPsi . '%');
            })
            ->when($search_firma_nume, function ($query, $search_firma_nume) {
                return $query->where('nume_client', 'like', '%' . $search_firma_nume . '%');
            })
            ->when($search_salariat, function ($query, $search_salariat) {
                return $query->where('salariat', 'like', '%' . $search_salariat . '%');
            })
            ->when($search_cnp, function ($query, $search_cnp) {
                return $query->where('cnp', 'like', '%' . $search_cnp . '%');
            })
            ->when($search_traseu, function ($query, $search_traseu) {
                return $query->where('traseu', $search_traseu);
            })
            ->when($search_de_rezolvat == 'da', function ($query, $search_traseu) {
                return $query->where(function ($query) {
                    $query->where('semnat_ssm', 'Lipsa')
                        ->orwhere('semnat_ssm', 'n.de s')
                        ->orwhere('semnat_psi', 'Lipsa')
                        ->orwhere('semnat_psi', 'n.de s');
                });
            })
            ->when($searchDataInc, function ($query, $searchDataInc) {
                return $query->where('data_incetare', 'like', '%' . $searchDataInc . '%');
            })
            ->when($searchActionar, function ($query, $searchActionar) {
                return $query->where('actionar', 'like', '%' . $searchActionar . '%');
            })
            ->when($searchObservatii, function ($query, $searchObservatii) {
                return $query->where('observatii_1', 'like', '%' . $searchObservatii . '%')
                            ->orWhere('observatii_2', 'like', '%' . $searchObservatii . '%');
            });

        $salariati = $query
                        ->orderBy('nume_client')
                        ->orderByRaw(DB::raw("
                                case when salariat like '%revisal%' then 0 else 1 end ASC,
                                case when salariat like '%situatie%' then 0 else 1 end ASC,
                                case when salariat like '%3 luni%' then 0 else 1 end ASC,
                                case when salariat like '%3luni%' then 0 else 1 end ASC,
                                case when salariat like '%6 luni%' then 0 else 1 end ASC,
                                case when salariat like '%6luni%' then 0 else 1 end ASC,
                                case when
                                    data_incetare like '%înc%' or
                                    data_incetare like '%lip%' or
                                    data_incetare like '%susp%' or
                                    data_incetare like '%c.c.c%' or
                                    data_incetare like '%ccc%' or
                                    data_incetare like '%cm%'
                                then 0 else 1 end DESC
                            "))
                        // ->orderBy('salariat')
                        ->orderBy($campSortare, $ordineSortare)
                        ->simplePaginate(200);

        $nrSalariatiDeRezolvat = SsmSalariat::
                where('semnat_ssm', 'Lipsa')
                ->orwhere('semnat_ssm', 'n.de s')
                ->orwhere('semnat_psi', 'Lipsa')
                ->orwhere('semnat_psi', 'n.de s')
                ->count();

        $lista_firma = SsmSalariat::select('nume_client')->groupBy('nume_client')->get();
        $lista_traseu = SsmSalariat::select('traseu')->groupBy('traseu')->get();

        $request->session()->forget('salariat_return_url');

        return view('ssm.salariati.index', compact('salariati', 'searchDataSsmPsi', 'search_firma_nume', 'search_salariat', 'search_cnp', 'search_traseu', 'search_de_rezolvat', 'lista_firma', 'lista_traseu', 'nrSalariatiDeRezolvat', 'searchDataInc', 'searchActionar', 'searchObservatii'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->session()->get('salariat_return_url') ?? $request->session()->put('salariat_return_url', url()->previous());

        return view('ssm.salariati.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $salariat = SsmSalariat::create($this->validateRequest($request));

        return redirect($request->session()->get('salariat_return_url') ?? ('/ssm/salariati'))
            ->with('status', 'Salariatul „' . ($salariat->salariat ?? '') . '” a fost adăugat cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Salariat  $salariat
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Salariat $salariat)
    {
        $request->session()->get('salariat_return_url') ?? $request->session()->put('salariat_return_url', url()->previous());

        return view('ssm.salariati.show', compact('salariat', 'serviciu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SsmSalariat  $salariat
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, SsmSalariat $salariat)
    {
        $request->session()->get('salariat_return_url') ?? $request->session()->put('salariat_return_url', url()->previous());

        return view('ssm.salariati.edit', compact('salariat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SsmSalariat  $salariat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SsmSalariat $salariat)
    {
        $salariat->update($this->validateRequest($request));

        return redirect($request->session()->get('salariat_return_url') ?? ('/ssm/salariati'))
            ->with('status', 'Salariatul „' . ($salariat->salariat ?? '') . '” a fost modificat cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SsmSalariat  $salariat
     * @return \Illuminate\Http\Response
     */
    public function destroy(SsmSalariat $salariat)
    {
        $salariat->delete();

        return back()->with('status', 'Salariatul „' . ($salariat->salariat ?? '') . '” a fost șters cu succes!');
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
                'nume_client' => 'required|max:200',
                'salariat' => 'nullable|max:200',
                'data_ssm_psi' => 'required|max:200',
                'semnat_anexa' => 'nullable|max:200',
                'semnat_eip' => 'nullable|max:200',
                'cnp' => 'nullable|max:200',
                'semnat_ssm' => 'required|max:200',
                'semnat_psi' => 'required|max:200',
                'functia' => 'nullable|max:200',
                'med_muncii' => 'nullable|max:200',
                // 'med_muncii_zi' => 'nullable|max:200',
                // 'med_muncii_luna' => 'nullable|max:200',
                // 'med_muncii_an' => 'nullable|max:200',
                'actionar' => 'nullable|max:200',
                'data_angajare' => 'nullable|max:200',
                'data_incetare' => 'nullable|max:200',
                'status' => 'nullable|max:200',
                'traseu' => 'nullable|max:200',
                'observatii_1' => 'nullable|max:2000',
                'observatii_2' => 'nullable|max:2000'
            ],
            [

            ]
        );
    }

    public function modificaSelectati(Request $request)
    {
        $request->validate(
            [
                'salariati_selectati' => 'required|array|between:1,100',
                'nume_client' => 'required_without_all:functia,traseu,data_ssm_psi,semnat_ssm,semnat_psi,semnat_anexa,semnat_eip|max:200',
                'functia' => 'nullable|max:200',
                'traseu' => 'nullable|max:200',
                'modificariGlobaleObservatii' => 'nullable|max:200',
                'modificariGlobaleData_ssm_psi' => 'nullable|max:200',
                'modificariGlobaleSemnat_ssm' => 'nullable|max:200',
                'modificariGlobaleSemnat_psi' => 'nullable|max:200',
                'modificariGlobaleSemnatAnexa' => 'nullable|max:200',
                'semnat_eip' => 'nullable|max:200',
            ],
            [
                'salariati_selectati.required' => 'Nu ați selectat nici un salariat!',
                'required_without_all' => 'Nu ați ales nici un câmp de modificat!'
            ]
            );

        $salariati = SsmSalariat::find($request->salariati_selectati);

        foreach ($salariati as $salariat){
            $request->nume_client ? $salariat->nume_client = $request->nume_client : '';
            $request->functia ? $salariat->functia = $request->functia : '';
            $request->traseu ? $salariat->traseu = $request->traseu : '';
            $request->modificariGlobaleData_ssm_psi ? $salariat->data_ssm_psi = $request->modificariGlobaleData_ssm_psi : '';
            $request->modificariGlobaleSemnat_ssm ? $salariat->semnat_ssm = $request->modificariGlobaleSemnat_ssm : '';
            $request->modificariGlobaleSemnat_psi ? $salariat->semnat_psi = $request->modificariGlobaleSemnat_psi : '';
            $request->modificariGlobaleSemnatAnexa ? $salariat->semnat_anexa = $request->modificariGlobaleSemnatAnexa : '';
            $request->modificariGlobaleSemnatEip ? $salariat->semnat_eip = $request->modificariGlobaleSemnatEip : '';
            $request->modificariGlobaleObservatii ? $salariat->observatii_1 = $request->modificariGlobaleObservatii : '';

            $salariat->save();
        }

        return back()->with('status', 'Cei ' . count($salariati) . ' Salariați au fost modificați cu succes!');
    }

    public function duplica(Request $request, SsmSalariat $salariat)
    {
        $salariat = $salariat->replicate(['created_at', 'updated_at']);

        $salariat->salariat = $salariat->salariat . ' DUPLICAT';

        $salariat->save();

        $request->session()->get('salariat_return_url') ?? $request->session()->put('salariat_return_url', url()->previous());

        return view('ssm.salariati.edit', compact('salariat'));
    }

    public function axiosModificareSalariatiDirectDinIndex(Request $request)
    {
        SsmSalariat::where('id', $request->salariatId)->update([$request->camp => $request->valoare]);
        // SsmSalariat::where()
        // $avans->suma = $request->avansSuma;
        // $avans->save();

        return response()->json([
            'raspuns' => "Actualizat",
            'salariatId' => $request->salariatId,
            'camp' => $request->camp,
        ]);
    }
}
