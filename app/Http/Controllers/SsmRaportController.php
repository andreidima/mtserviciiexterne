<?php

namespace App\Http\Controllers;

use App\Models\SsmFirma;
use App\Models\SsmSalariat;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class SsmRaportController extends Controller
{
    public function firme(Request $request)
    {
        $search_ssm_luna = $request->search_ssm_luna;
        $search_psi_luna = $request->search_psi_luna;
        // $search_traseu = $request->search_traseu;
        $search_actionar = $request->search_actionar;

        $lista_ssm_luna = SsmFirma::select('ssm_luna')->groupBy('ssm_luna')->get();
        $lista_psi_luna = SsmFirma::select('psi_luna')->groupBy('psi_luna')->get();
        // $lista_traseu = SsmFirma::select('traseu')->groupBy('traseu')->get();
        $lista_actionar = SsmFirma::select('actionar')->groupBy('actionar')->get();

        $firme = SsmFirma::
            where(function($query) use ($search_ssm_luna, $search_psi_luna) {
                return $query->where('ssm_luna', $search_ssm_luna)
                            ->orwhere('psi_luna', $search_psi_luna);
            })
            // ->orwhere('traseu', $search_traseu)
            ->when($search_actionar, function($query) use ($search_actionar) {
                return $query->where('actionar', $search_actionar);
            })
            // ->where('actionar', $search_actionar)
            ->orderBy('traseu', 'asc')
            ->orderBy('nume')
            ->get();

        switch ($request->input('action')) {
            case 'exportHtml':
                return view('ssm.rapoarte.export.firmePdf', compact('firme', 'search_ssm_luna', 'search_psi_luna'));
                break;
            case 'exportPdf':
                $pdf = \PDF::loadView('ssm.rapoarte.export.firmePdf', compact('firme', 'search_ssm_luna', 'search_psi_luna'))
                    ->setPaper('a4', 'portrait');
                $pdf->getDomPDF()->set_option("enable_php", true);
                return $pdf->download('Raport SSM - firme.pdf');
                // return $pdf->stream();
                break;
            default:
                return view('ssm.rapoarte.firme', compact('firme', 'search_ssm_luna', 'search_psi_luna', 'search_actionar', 'lista_ssm_luna', 'lista_psi_luna', 'lista_actionar'));
        }

    }

    public function firmeExportPDF(Request $request, $ssm_luna = null, $psi_luna = null)
    {
        $firme = SsmFirma::
            where('ssm_luna', $ssm_luna)
            ->orwhere('psi_luna', $psi_luna)
            ->orderBy('traseu', 'asc')
            ->orderBy('nume')
            ->get();

        if ($request->view_type === 'export-html') {
            return view('ssm.rapoarte.export.firmePdf', compact('firme', 'ssm_luna', 'psi_luna'));
        } elseif ($request->view_type === 'export-pdf') {
            $pdf = \PDF::loadView('ssm.rapoarte.export.firmePdf', compact('firme', 'ssm_luna', 'psi_luna'))
                ->setPaper('a4', 'portrait');
            $pdf->getDomPDF()->set_option("enable_php", true);
            return $pdf->download('Raport SSM - firme.pdf');
            // return $pdf->stream();
        }
    }

    public function salariati(Request $request)
    {
        $request->validate(
            ['search_firma' => 'nullable|min:3',],
            ['search_firma.min' => 'Dacă doriți să căutați după numele unei firme, introduceți minim 3 caractere',]
        );

        $search_firma = \Request::get('search_firma');
        $search_status = \Request::get('search_status');
        $search_data_ssm_psi = \Request::get('search_data_ssm_psi');
        $search_semnat_ssm = \Request::get('search_semnat_ssm');
        $search_semnat_psi = \Request::get('search_semnat_psi');
        $search_nerezolvate = \Request::get('search_nerezolvate');

        $lista_data_ssm_psi = SsmSalariat::select('data_ssm_psi')->groupBy('data_ssm_psi')->get();
        $lista_semnat_ssm = SsmSalariat::select('semnat_ssm')->groupBy('semnat_ssm')->get();
        $lista_semnat_psi = SsmSalariat::select('semnat_psi')->groupBy('semnat_psi')->get();

        if ($search_nerezolvate == '1'){
            $salariati = SsmSalariat::where('semnat_ssm', 'Lipsa')
                ->orwhere('semnat_ssm', 'n.de s')
                ->orwhere('semnat_psi', 'Lipsa')
                ->orwhere('semnat_psi', 'n.de s')
                ->get();
        } else {
            $salariati = SsmSalariat::
                // where('data_ssm_psi', $search_data_ssm_psi)
                where(function($query) use($search_data_ssm_psi, $search_firma, $search_status) {
                    $query->where('data_ssm_psi', $search_data_ssm_psi);
                    if (strlen($search_firma) >= 3){
                        $query->orwhere('nume_client',  'like', '%' . $search_firma . '%');
                    }
                })
                ->when($search_status, function ($query) use ($search_status) {
                    if ($search_status === 'activi'){
                        $query
                            // ->where('status', '!=', 'CCC')
                            // ->where('status', '!=', 'incetat')
                            // ->where('status', '!=', 'lipsa')
                            ->where(function($query) {
                                $query->where([
                                            ['data_incetare',  'not like', '%c.c.c%'],
                                            ['data_incetare',  'not like', '%susp%'],
                                            ['data_incetare',  'not like', '%înc%'],
                                            ['data_incetare',  'not like', '%inc%'],
                                            ['data_incetare',  'not like', '%lip%'],
                                            ['data_incetare',  'not like', '%lip%'],
                                        ])
                                    ->orwhereNull('data_incetare');
                            });
                    }
                })
                ->when($search_semnat_ssm, function ($query, $search_semnat_ssm) {
                    return $query->where('semnat_ssm', $search_semnat_ssm);
                })
                ->when($search_semnat_psi, function ($query, $search_semnat_psi) {
                    return $query->where('semnat_psi', $search_semnat_psi);
                })
                ->orderBy('nume_client', 'asc')
                ->orderBy('salariat')
                ->get();
        }

        switch ($request->input('action')) {
            case 'exportHtml':
                return view('ssm.rapoarte.export.salariatiPdf', compact('salariati', 'search_data_ssm_psi', 'search_semnat_ssm', 'search_semnat_psi', 'search_firma'));
                break;
            case 'exportPdf':
                $pdf = \PDF::loadView('ssm.rapoarte.export.salariatiPdf', compact('salariati', 'search_data_ssm_psi', 'search_semnat_ssm', 'search_semnat_psi', 'search_firma'))
                    ->setPaper('a4', 'portrait');
                $pdf->getDomPDF()->set_option("enable_php", true);
                return $pdf->download('Raport SSM - salariati.pdf');
                // return $pdf->stream();
                break;
            default:
                return view('ssm.rapoarte.salariati', compact('salariati', 'search_data_ssm_psi', 'search_semnat_ssm', 'search_semnat_psi', 'search_firma', 'search_status',
                    'lista_data_ssm_psi', 'lista_semnat_ssm', 'lista_semnat_psi'));
                break;
        }
    }

    public function salariatiExportPDF(Request $request, $data_ssm_psi = null, $semnat_ssm = null, $semnat_psi = null)
    {
        ($semnat_ssm === 'search_semnat_ssm') ? ($semnat_ssm = null) : null;
        ($semnat_psi === 'search_semnat_psi') ? ($semnat_psi = null) : null;

        $salariati = SsmSalariat::
            where('data_ssm_psi', $data_ssm_psi)
            ->when($semnat_ssm, function ($query, $semnat_ssm) {
                return $query->where('semnat_ssm', $semnat_ssm);
            })
            ->when($semnat_psi, function ($query, $semnat_psi) {
                return $query->where('semnat_psi', $semnat_psi);
            })
            ->orderBy('nume_client', 'asc')
            ->orderBy('salariat')
            ->get();

        if ($request->view_type === 'export-html') {
            return view('ssm.rapoarte.export.salariatiPdf', compact('salariati', 'data_ssm_psi', 'semnat_ssm', 'semnat_psi'));
        } elseif ($request->view_type === 'export-pdf') {
            $pdf = \PDF::loadView('ssm.rapoarte.export.salariatiPdf', compact('salariati', 'data_ssm_psi', 'semnat_ssm', 'semnat_psi'))
                ->setPaper('a4', 'portrait');
            $pdf->getDomPDF()->set_option("enable_php", true);
            return $pdf->download('Raport SSM - salariati.pdf');
            // return $pdf->stream();
        }
    }

    public function medicinaMunciiFirme(Request $request)
    {
        $search_firma = \Request::get('search_firma');
        $search_cui = \Request::get('search_cui');

        $firme = SsmFirma::
            when($search_firma, function ($query, $search_firma) {
                return $query->where('nume', 'like', '%' . $search_firma . '%');
            })
            ->when($search_cui, function ($query, $search_cui) {
                return $query->where('cui', 'like', '%' . $search_cui . '%');
            })
            ->orderBy('nume')
            ->simplePaginate(25);

        return view('rapoarte.medicinaMuncii.ssmFirme', compact('firme', 'search_firma', 'search_cui'));
    }

    public function medicinaMunciiSalariati(Request $request)
    {
        $search_nume_client = \Request::get('search_nume_client');
        $search_salariat = \Request::get('search_salariat');

        $salariati = SsmSalariat::
            when($search_nume_client, function ($query, $search_nume_client) {
                return $query->where('nume_client', 'like', '%' . $search_nume_client . '%');
            })
            ->when($search_salariat, function ($query, $search_salariat) {
                return $query->where('salariat', 'like', '%' . $search_salariat . '%');
            })
            ->orderBy('nume_client', 'asc')
            ->orderByRaw(DB::raw("
                    case when data_incetare like '%înc%' then 0 else 1 end DESC,
                    case when data_incetare like '%lip%' then 0 else 1 end DESC,
                    case when data_incetare like '%susp%' then 0 else 1 end DESC,
                    case when data_incetare like '%c.c.c%' then 0 else 1 end DESC
                "))
            ->orderBy('salariat');

        switch ($request->input('action')) {
            case 'export_pdf':
                $salariati = $salariati->get();
                if ($salariati->count() > 500){
                    return back()->with('error', 'Sunt selectați peste 500 de salariați. Micșorați aria de selecție sub 500 de salariați pentru a putea extrage datele.');
                } else{
                    // return view('rapoarte.medicinaMuncii.export.ssmSalariatiPdf', compact('salariati'));
                    $pdf = \PDF::loadView('rapoarte.medicinaMuncii.export.ssmSalariatiPdf', compact('salariati'))
                        ->setPaper('a4', 'portrait');
                    $pdf->getDomPDF()->set_option("enable_php", true);
                    return $pdf->download('Raport salariati SSM.pdf');
                    // return $pdf->stream();
                }
            default:
                $salariati = $salariati->simplePaginate(50);
                return view('rapoarte.medicinaMuncii.ssmSalariati', compact('salariati', 'search_nume_client', 'search_salariat'));
                break;
        }
    }

    public function medicinaMunciiSalariatiExportPdf(Request $request)
    {
        $search_nume_client = \Request::get('search_nume_client');

        dd($request, $request->result, \Request::get('result'), $search_nume_client);
    }
}
