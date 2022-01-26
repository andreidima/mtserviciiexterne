<?php

namespace App\Http\Controllers;

use App\Models\Firma;
use App\Models\FirmaSalariat;
use App\Models\FirmaStingator;
use App\Models\FirmaTraseu;
use App\Models\FirmaDomeniuDeActivitate;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class ImportInitialFisierExcelController extends Controller
{
    public function importFirme()
    {
        $firme_import = DB::table('import_firme')->get();

        foreach ($firme_import as $firma_import){
            $firma = new Firma;
            $firma->nume = $firma_import->B;
            $firma->cod_fiscal = $firma_import->C;
            $firma->localitate = $firma_import->E;
            $firma->nume_administrator = $firma_import->R;
            $firma->angajat_desemnat = $firma_import->S;

            //Traseu
            if ($firma_import->T){
                $traseu = FirmaTraseu::firstOrCreate([
                    'nume' => $firma_import->T
                ]);
                $firma->traseu_id = $traseu->id;
            }

            //Domeniu de activitate
            if ($firma_import->U){
                $domeniu_de_activitate = FirmaDomeniuDeActivitate::firstOrCreate([
                    'nume' => $firma_import->U
                ]);
                $firma->domeniu_de_activitate_id = $firma_import->id;
            }

            $firma->observatii = $firma_import->AA;
            // $firma-> = $firma_import->;
            $firma->save();
        }
        dd('stop');
    }

    public function importSalariati()
    {
        $salariati_import = DB::table('import_salariati')->get();

        foreach ($salariati_import as $salariat_import){
            $salariat = new FirmaSalariat;

            //Firma
            if ($salariat_import->B){
                $firma = FirmaTraseu::firstOrCreate([
                    'nume' => $salariat_import->B
                ]);
                $salariat->firma_id = $firma->id;
            }

            $salariat->nume = $salariat_import->C;
            $salariat->cnp = $salariat_import->I;
            $salariat->functie = $salariat_import->J;

            // Medicina muncii - data expirare - compusa din 3 coloane
            if(is_numeric($salariat_import->K) && is_numeric($salariat_import->L) && is_numeric($salariat_import->M)){
                $salariat->medicina_muncii_expirare = \Carbon\Carbon::now();
                $salariat->medicina_muncii_expirare->day = $salariat_import->K;
                $salariat->medicina_muncii_expirare->month = $salariat_import->L;
                $salariat->medicina_muncii_expirare->year = '20'.$salariat_import->M;
            }

            // try {
            //     \Carbon\Carbon::parse($salariat_import->O);
            // } catch (Carbon\Exceptions\InvalidFormatException $e) {
            //     echo 'invalid date, enduser understands the error message';
            // }
            // if(\Carbon\Carbon::parse($salariat_import->O)){
                // $salariat->data_angajare = $data_angajare;
            // }
            // dD(\Carbon\Carbon::createFromFormat('DD.MM.YYYY', $salariat_import->O));
            // if (\Carbon\Carbon::createFromFormat('DD.MM.YYYY', $salariat_import->O) !== false) {
            //     dd('false');
            //     $salariat->data_angajare = \Carbon\Carbon::createFromFormat('DD.MM.YYYY', $salariat_import->O);
            // }
            preg_match_all('#\d{2}.\d{2}.\d{2}#', $salariat_import->O, $results);
            if (sizeof($results) != 0) {
                if (!empty($results[0])){
                    // dd ($results, $results[0][0]);
                    echo $results[0][0] . '<br><br>';
                }
                // foreach ($results as $result){
                //     echo $result;
                // }
                // echo implode(', ', $results);
                // dd ($results, $results[0]);
                // echo $results[0];
            }
            // if (\DateTime::createFromFormat('d.m.Y', $salariat_import->O) !== false) {
            //     $salariat->data_angajare = \DateTime::createFromFormat('d.m.Y', $salariat_import->O)->format('yyyy-m-d');
            //     dd($salariat->data_angajare);
            // }

            // dd($salariat);

            $salariat->save();
        }
        dd('stop');
    }
}
