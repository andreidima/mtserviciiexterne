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
        $search_ssm_luna = \Request::get('search_ssm_luna');
        $search_psi_luna = \Request::get('search_psi_luna');

        $lista_ssm_luna = SsmFirma::select('ssm_luna')->groupBy('ssm_luna')->get();
        $lista_psi_luna = SsmFirma::select('psi_luna')->groupBy('psi_luna')->get();

        $firme = SsmFirma::
            where('ssm_luna', $search_ssm_luna)
            ->orwhere('psi_luna', $search_psi_luna)
            ->orderBy('traseu', 'asc')
            ->orderBy('nume')
            ->get();

        return view('ssm.rapoarte.firme', compact('firme', 'search_ssm_luna', 'search_psi_luna',
            'lista_ssm_luna', 'lista_psi_luna'));
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
        $search_data_ssm_psi = \Request::get('search_data_ssm_psi');
        $search_semnat_ssm = \Request::get('search_semnat_ssm');
        $search_semnat_psi = \Request::get('search_semnat_psi');

        $lista_data_ssm_psi = SsmSalariat::select('data_ssm_psi')->groupBy('data_ssm_psi')->get();
        $lista_semnat_ssm = SsmSalariat::select('semnat_ssm')->groupBy('semnat_ssm')->get();
        $lista_semnat_psi = SsmSalariat::select('semnat_psi')->groupBy('semnat_psi')->get();

        $salariati = SsmSalariat::
            where('data_ssm_psi', $search_data_ssm_psi)
            ->when($search_semnat_ssm, function ($query, $search_semnat_ssm) {
                return $query->where('semnat_ssm', $search_semnat_ssm);
            })
            ->when($search_semnat_psi, function ($query, $search_semnat_psi) {
                return $query->where('semnat_psi', $search_semnat_psi);
            })
            ->orderBy('nume_client', 'asc')
            ->orderBy('salariat')
            ->get();

        return view('ssm.rapoarte.salariati', compact('salariati', 'search_data_ssm_psi', 'search_semnat_ssm', 'search_semnat_psi',
            'lista_data_ssm_psi', 'lista_semnat_ssm', 'lista_semnat_psi'));
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
            ->orderBy('salariat')
            ->simplePaginate(50);

        return view('rapoarte.medicinaMuncii.ssmSalariati', compact('salariati', 'search_nume_client', 'search_salariat'));
    }
}
