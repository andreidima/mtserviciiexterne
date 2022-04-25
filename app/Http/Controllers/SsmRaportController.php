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

    public function salariatiExportPDF(Request $request, $data_ssm_psi = null, $semnat_ssm = null)
    {
        $salariati = SsmSalariat::
            where('data_ssm_psi', $data_ssm_psi)
            ->orwhere('semnat_ssm', $semnat_ssm)
            ->orderBy('traseu', 'asc')
            ->orderBy('nume')
            ->get();

        if ($request->view_type === 'export-html') {
            return view('ssm.rapoarte.export.salariatiPdf', compact('salariati', 'data_ssm_psi', 'semnat_ssm'));
        } elseif ($request->view_type === 'export-pdf') {
            $pdf = \PDF::loadView('ssm.rapoarte.export.salariatiPdf', compact('salariati', 'data_ssm_psi', 'semnat_ssm'))
                ->setPaper('a4', 'portrait');
            $pdf->getDomPDF()->set_option("enable_php", true);
            return $pdf->download('Raport SSM - salariati.pdf');
            // return $pdf->stream();
        }
    }
}
