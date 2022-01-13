<?php

namespace App\Http\Controllers;

use App\Models\Firma;
use App\Models\FirmaSalariat;
use App\Models\FirmaStingator;
use App\Models\FirmaTraseu;
use App\Models\FirmaDomeniuDeActivitate;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function importStingatoare()
    {
        $stingatoare_import = DB::table('import_stingatoare_firme')->take(10)->get();
        // dd($stingatoare_import);

        foreach ($stingatoare_import as $stingator_import){

            $stingator = new FirmaStingator;


            //Firma
            if ($stingator_import->{'DENUMIREA FIRMEI'}){
                $firma = Firma::firstOrCreate([
                    'nume' => $stingator_import->{'DENUMIREA FIRMEI'},
                    'cod_fiscal' => $stingator_import->{'C.I.F'}
                ]);

                $stingator->firma_id = $firma->id;
            }


            //Traseu
            if ($stingator_import->RUTA){
                $traseu = FirmaTraseu::firstOrCreate([
                    'nume' => $stingator_import->RUTA
                ]);
                $firma->traseu_id = $traseu->id;
            }


            if (strpos($stingator_import->{'TIP STING.'}, ';') !== false) {
                // Se intra aici daca in campul stingatoare sunt mai multe tipuri
                $stingatoare = $stingator_import->{'TIP STING.'};

                // Se elimina toate spatiile albe
                $stingatoare = preg_replace('/\s+/', '', $stingatoare);

                $stingatoare_array = explode(';', $stingatoare);

                echo $stingator_import->{'NR. STING'};
                    echo '<br>';
                foreach($stingatoare_array as $stingator_array){
                    echo $stingator_array;
                    echo '<br>';
                }
                    echo '<br>';



            } else {
                switch($stingator_import->{'TIP STING.'}){
                    case ('p1' || 'P1'):
                        $stingator->p6 = $stingator_import->{'NR. STING'};
                        break;
                    case ('p2' || 'P2'):
                        $stingator->p6 = $stingator_import->{'NR. STING'};
                        break;
                    case ('p3' || 'P3'):
                        $stingator->p6 = $stingator_import->{'NR. STING'};
                        break;
                    case ('p6' || 'P6'):
                        $stingator->p6 = $stingator_import->{'NR. STING'};
                        break;
                    case ('p9' || 'P9'):
                        $stingator->p6 = $stingator_import->{'NR. STING'};
                        break;
                    case ('sm6' || 'SM6'):
                        $stingator->p6 = $stingator_import->{'NR. STING'};
                        break;
                    case ('sm9' || 'SM9'):
                        $stingator->p6 = $stingator_import->{'NR. STING'};
                        break;
                    case ('p50' || 'P50'):
                        $stingator->p6 = $stingator_import->{'NR. STING'};
                        break;
                    case ('p100' || 'P100'):
                        $stingator->p6 = $stingator_import->{'NR. STING'};
                        break;
                    case ('sm50' || 'SM50'):
                        $stingator->p6 = $stingator_import->{'NR. STING'};
                        break;
                    case ('sm100' || 'SM100'):
                        $stingator->p6 = $stingator_import->{'NR. STING'};
                        break;
                    case ('g2' || 'G2'):
                        $stingator->p6 = $stingator_import->{'NR. STING'};
                        break;
                    case ('g5' || 'G5'):
                        $stingator->p6 = $stingator_import->{'NR. STING'};
                        break;
                }
            }

            // $stingator->save();
        }

    }
}
