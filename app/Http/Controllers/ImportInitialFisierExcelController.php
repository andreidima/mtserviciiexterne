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

    public function importStingatoare()
    {
        $stingatoare_import = DB::table('import_stingatoare_firme')
            ->where('id', '>', '660')
            // ->take(500)
            ->get();
        // dd($stingatoare_import);

        // Folosit pentru a vedea la ce rand din excel apar erorirle
        $iteratie = 1;

        foreach ($stingatoare_import as $stingator_import){

            $stingator = new FirmaStingator;

// echo $stingator_import->{'DENUMIREA FIRMEI'} . ' - ' . $stingator_import->{'C.I.F'} . '<br><br>';
            //Firma
            if ($stingator_import->{'DENUMIREA FIRMEI'}){
                $firma = Firma::firstOrCreate(
                    [
                        'nume' => $stingator_import->{'DENUMIREA FIRMEI'},
                        'cod_fiscal' => $stingator_import->{'C.I.F'}
                    ],
                    [
                        'telefon' => $stingator_import->{'TELEFON'},
                    ]
                );

                $stingator->firma_id = $firma->id;
            }


            //Traseu
            if ($stingator_import->RUTA){
                $traseu = FirmaTraseu::firstOrCreate([
                    'nume' => $stingator_import->RUTA
                ]);
                $firma->traseu_id = $traseu->id;
            }


            // if (
            //     (strpos($stingator_import->{'TIP STING.'}, ';') !== false) ||
            //     (strpos($stingator_import->{'TIP STING.'}, ':') !== false) ||
            //     (strpos($stingator_import->{'TIP STING.'}, '-') !== false)
            // ){
                // echo ($iteratie++) . '-';
                // echo preg_match('(;|-|:)', $stingator_import->{'TIP STING.'});
                // echo '<br><br>';
            if(preg_match('(;|-|:)', $stingator_import->{'TIP STING.'}) === 1){
                // Se intra aici daca in campul stingatoare sunt mai multe tipuri
                $stingatoare = $stingator_import->{'TIP STING.'};

                // Se elimina toate spatiile albe
                $stingatoare = preg_replace('/\s+/', '', $stingatoare);

                $stingatoare_array = preg_split('/ (;|-|:) /', $stingatoare);
                $stingatoare_array = preg_split('/[;|-|:]/', $stingatoare);
                // if (strpos($stingator_import->{'TIP STING.'}, ';')){
                //     $stingatoare_array = explode(';', $stingatoare);
                // } elseif (strpos($stingator_import->{'TIP STING.'}, ':'){
                //     $stingatoare_array = explode(':', $stingatoare);
                // }
                // $stingatoare_array = explode(';', $stingatoare);

                //     echo '<br>';
                foreach($stingatoare_array as $stingator_string){
                    if(!empty($stingator_string)){
                        // se extrage primul numar din $stingator_string
                        $numar_stingatoare = substr($stingator_string, 0, strspn($stingator_string, "0123456789"));

                        if($numar_stingatoare){
                            // se sterge primul numar din $stingator_string, astfel ramanand tipul stingatorului
                            $tip_stingatoare = substr($stingator_string, strlen($numar_stingatoare));

                            // Daca $numar_stingatoare este '', inseamna ca acolo este doar 1 stingator, asa ca automat i se va da valoarea 1;
                            ($numar_stingatoare == '') ? ($numar_stingatoare = 1) : '';

                            $stingator->{$tip_stingatoare} = $numar_stingatoare;
                        }
                        // echo $stingator->{$tip_stingatoare};
                        // echo ' - ';
                        // echo $stingator_string;
                        // echo '<br>';
                    }
                }
                    // echo '<br>';

                // echo $stingator_import->{'TIP STING.'};
                // echo '<br><br>';

            } else {
                switch($stingator_import->{'TIP STING.'}){
                    case 'p1':
                    case 'P1':
                        $stingator->p1 = is_numeric(is_numeric($stingator_import->{'NR. STING'}) ? $stingator_import->{'NR. STING'} : 0) ? is_numeric($stingator_import->{'NR. STING'}) ? $stingator_import->{'NR. STING'} : 0 : 0;
                        break;
                    case 'p2':
                    case 'P2':
                        $stingator->p2 = is_numeric($stingator_import->{'NR. STING'}) ? $stingator_import->{'NR. STING'} : 0;
                        break;
                    case 'p3':
                    case 'P3':
                        $stingator->p3 = is_numeric($stingator_import->{'NR. STING'}) ? $stingator_import->{'NR. STING'} : 0;
                        break;
                    case 'p6':
                    case 'P6':
                        $stingator->p6 = is_numeric($stingator_import->{'NR. STING'}) ? $stingator_import->{'NR. STING'} : 0;
                        break;
                    case 'p9':
                    case 'P9':
                        $stingator->p9 = is_numeric($stingator_import->{'NR. STING'}) ? $stingator_import->{'NR. STING'} : 0;
                        break;
                    case 'sm6':
                    case 'SM6':
                        $stingator->sm6 = is_numeric($stingator_import->{'NR. STING'}) ? $stingator_import->{'NR. STING'} : 0;
                        break;
                    case 'sm9':
                    case 'SM9':
                        $stingator->sm9 = is_numeric($stingator_import->{'NR. STING'}) ? $stingator_import->{'NR. STING'} : 0;
                        break;
                    case 'p50':
                    case 'P50':
                        $stingator->p50 = is_numeric($stingator_import->{'NR. STING'}) ? $stingator_import->{'NR. STING'} : 0;
                        break;
                    case 'p100':
                    case 'P100':
                        $stingator->p100 = is_numeric($stingator_import->{'NR. STING'}) ? $stingator_import->{'NR. STING'} : 0;
                        break;
                    case 'sm50':
                    case 'SM50':
                        $stingator->sm50 = is_numeric($stingator_import->{'NR. STING'}) ? $stingator_import->{'NR. STING'} : 0;
                        break;
                    case 'sm100':
                    case 'SM100':
                        $stingator->sm100 = is_numeric($stingator_import->{'NR. STING'}) ? $stingator_import->{'NR. STING'} : 0;
                        break;
                    case 'g2':
                    case 'G2':
                        $stingator->g2 = is_numeric($stingator_import->{'NR. STING'}) ? $stingator_import->{'NR. STING'} : 0;
                        break;
                    case 'g5':
                    case 'G5':
                        $stingator->g5 = is_numeric($stingator_import->{'NR. STING'}) ? $stingator_import->{'NR. STING'} : 0;
                        break;
                    default:
                        // dd($stingator_import);
                        echo $stingator_import->{'DENUMIREA FIRMEI'};
                        echo " -> ";
                        echo $stingator_import->{'TIP STING.'};
                        echo '<br><br>';
                        break;
                }
            }

            // Creare data expirare
            $stingator->stingatoare_expirare = Carbon::create($stingator_import->{'AN'}, $stingator_import->{'LUNA'}, 1);

            // Numarul total de stingatoare din excel, pentru verificare ulterioara
            $stingator->total = is_numeric($stingator_import->{'NR. STING'}) ? $stingator_import->{'NR. STING'} : 0;

            // Afisarea iteratiei pentru a vedea la ce rand din excel apar erorile
            echo ($iteratie++) . '-';
            // echo '<br><br>';

            $stingator->save();
        }

        echo 'done final';
    }
}
