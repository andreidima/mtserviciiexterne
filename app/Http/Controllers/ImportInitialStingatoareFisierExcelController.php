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

class ImportInitialStingatoareFisierExcelController extends Controller
{
    public function importStingatoare()
    {
        $stingatoare_import =
            // DB::table('import_stingatoare_firme')
            DB::table('import_stingatoare_parohii')
            // ->where('id', '>', '170')
            // ->take(2)
            ->get();
        // dd($stingatoare_import);

        // Folosit pentru a vedea la ce rand din excel apar erorirle
        $iteratie = 1;

        foreach ($stingatoare_import as $stingator_import){

            $stingator = new FirmaStingator;

            //Traseu
            if ($stingator_import->RUTA){
                $traseu = FirmaTraseu::firstOrCreate([
                    'nume' => $stingator_import->RUTA
                ]);
            }

            //Firma
            if ($stingator_import->{'DENUMIREA FIRMEI'}){
                // $firma = Firma::firstOrCreate(
                //     [
                //         'nume' => $stingator_import->{'DENUMIREA FIRMEI'},
                //         'cod_fiscal' => $stingator_import->{'C.I.F'}
                //     ],
                //     [
                //         'telefon' => $stingator_import->{'TELEFON'},
                //         'traseu_id' => $traseu->id,
                //     ]
                // );
                $firma = Firma::create(
                    [
                        // 'nume' => $stingator_import->{'DENUMIREA FIRMEI'},
                        'nume' => 'Parohia ' . $stingator_import->{'DENUMIREA FIRMEI'},
                        'cod_fiscal' => $stingator_import->{'C.I.F'},
                        'telefon' => $stingator_import->{'TELEFON'},
                        'traseu_id' => $traseu->id,
                        'stingatoare_serviciu' => 1,
                    ]
                );

                $stingator->firma_id = $firma->id;
            }


            // Se elimina toate spatiile albe
            $stingator_import->{'TIP STING.'} = preg_replace('/\s+/', '', $stingator_import->{'TIP STING.'});
            // echo $stingator_import->{'TIP STING.'} . '<br>';

            // Se elimina caracterele nedorite de la inceput si sfarsit, pentru a nu se face un array cu elemente goale
            $stingator_import->{'TIP STING.'} = trim($stingator_import->{'TIP STING.'}, ";-:',+");
            // echo $stingator_import->{'TIP STING.'} . '<br><br>';

            if(preg_match("(;|-|:|'|,|\+)", $stingator_import->{'TIP STING.'}) === 1){
                // Se intra aici daca in campul stingatoare sunt mai multe tipuri
                $stingatoare = $stingator_import->{'TIP STING.'};

                // $stingatoare_array = preg_split('/ (;|-|:) /', $stingatoare);
                $stingatoare_array = preg_split("/;|-|:|'|,|\+/", $stingatoare);
                // dd($stingatoare_array);
                // if (strpos($stingator_import->{'TIP STING.'}, ';')){
                //     $stingatoare_array = explode(';', $stingatoare);
                // } elseif (strpos($stingator_import->{'TIP STING.'}, ':'){
                //     $stingatoare_array = explode(':', $stingatoare);
                // }
                // $stingatoare_array = explode(';', $stingatoare);

                    // echo '<br><br>';
                foreach($stingatoare_array as $stingator_string){
                    // echo 'String: ' . $stingator_string . '<br>';
                    if(!empty($stingator_string)){
                        // se extrage primul numar din $stingator_string
                        $numar_stingatoare = substr($stingator_string, 0, strspn($stingator_string, "0123456789"));

                        if($numar_stingatoare){
                            // se sterge primul numar din $stingator_string, astfel ramanand tipul stingatorului
                            $tip_stingatoare = substr($stingator_string, strlen($numar_stingatoare));
                        } else{
                            $tip_stingatoare = $stingator_string;
                        }

                        // Se transforma in litere mici numele stingatorului, pentru a nu fi probleme la importul in baza de date
                        $tip_stingatoare = strtolower($tip_stingatoare);

                        // echo $tip_stingatoare . ' = ' . $numar_stingatoare . '<br>';

                        // Verificare daca exista acel tip de stingator (acea coloana) in baza de date
                        if (in_array($tip_stingatoare, ['p1', 'p2', 'p3', 'p4', 'p5', 'p6', 'p9', 'p20', 'p50', 'p100', 'sm3', 'sm6', 'sm9', 'sm50', 'sm100', 'g2', 'g5'], true)){
                            // Daca $numar_stingatoare este '', inseamna ca acolo este doar 1 stingator, asa ca automat i se va da valoarea 1;
                            ($numar_stingatoare == '') ?
                                ( (count($stingatoare_array) == 1) ?
                                    (is_numeric($stingator_import->{'NR. STING'}) ? $stingator_import->{'NR. STING'} : 0)
                                    :
                                    ($numar_stingatoare = 1)
                                )
                                : '';

                            $stingator->{$tip_stingatoare} = $numar_stingatoare;
                        } else {
                            echo $iteratie . '. ' . 'Stingatoare: ' . $tip_stingatoare . '<br>';
                        }

                    }
                }

            } else {
                // se extrage primul numar din $stingator_string
                $numar_stingatoare = substr($stingator_import->{'TIP STING.'}, 0, strspn($stingator_import->{'TIP STING.'}, "0123456789"));

                if($numar_stingatoare){
                    // se sterge primul numar din $stingator_string, astfel ramanand tipul stingatorului
                    $stingator_import->{'TIP STING.'} = substr($stingator_import->{'TIP STING.'}, strlen($numar_stingatoare));
                }

                switch(strtolower($stingator_import->{'TIP STING.'})){
                    case 'p1':
                    // case 'P1':
                        $stingator->p1 = is_numeric($stingator_import->{'NR. STING'}) ? $stingator_import->{'NR. STING'} : 0;
                        break;
                    case 'p2':
                    // case 'P2':
                        $stingator->p2 = is_numeric($stingator_import->{'NR. STING'}) ? $stingator_import->{'NR. STING'} : 0;
                        break;
                    case 'p3':
                    // case 'P3':
                        $stingator->p3 = is_numeric($stingator_import->{'NR. STING'}) ? $stingator_import->{'NR. STING'} : 0;
                        break;
                    case 'p4':
                    // case 'P3':
                        $stingator->p3 = is_numeric($stingator_import->{'NR. STING'}) ? $stingator_import->{'NR. STING'} : 0;
                        break;
                    case 'p5':
                    // case 'P3':
                        $stingator->p3 = is_numeric($stingator_import->{'NR. STING'}) ? $stingator_import->{'NR. STING'} : 0;
                        break;
                    case 'p6':
                    // case 'P6':
                        $stingator->p6 = is_numeric($stingator_import->{'NR. STING'}) ? $stingator_import->{'NR. STING'} : 0;
                        break;
                    case 'p9':
                    // case 'P9':
                        $stingator->p9 = is_numeric($stingator_import->{'NR. STING'}) ? $stingator_import->{'NR. STING'} : 0;
                        break;
                    case 'p20':
                    // case 'P3':
                        $stingator->p3 = is_numeric($stingator_import->{'NR. STING'}) ? $stingator_import->{'NR. STING'} : 0;
                        break;
                    case 'p50':
                    // case 'P50':
                        $stingator->p50 = is_numeric($stingator_import->{'NR. STING'}) ? $stingator_import->{'NR. STING'} : 0;
                        break;
                    case 'p100':
                    // case 'P100':
                        $stingator->p100 = is_numeric($stingator_import->{'NR. STING'}) ? $stingator_import->{'NR. STING'} : 0;
                        break;
                    case 'sm3':
                    // case 'SM6':
                        $stingator->sm6 = is_numeric($stingator_import->{'NR. STING'}) ? $stingator_import->{'NR. STING'} : 0;
                        break;
                    case 'sm6':
                    // case 'SM6':
                        $stingator->sm6 = is_numeric($stingator_import->{'NR. STING'}) ? $stingator_import->{'NR. STING'} : 0;
                        break;
                    case 'sm9':
                    // case 'SM9':
                        $stingator->sm9 = is_numeric($stingator_import->{'NR. STING'}) ? $stingator_import->{'NR. STING'} : 0;
                        break;
                    case 'sm50':
                    // case 'SM50':
                        $stingator->sm50 = is_numeric($stingator_import->{'NR. STING'}) ? $stingator_import->{'NR. STING'} : 0;
                        break;
                    case 'sm100':
                    // case 'SM100':
                        $stingator->sm100 = is_numeric($stingator_import->{'NR. STING'}) ? $stingator_import->{'NR. STING'} : 0;
                        break;
                    case 'g2':
                    // case 'G2':
                        $stingator->g2 = is_numeric($stingator_import->{'NR. STING'}) ? $stingator_import->{'NR. STING'} : 0;
                        break;
                    case 'g5':
                    // case 'G5':
                        $stingator->g5 = is_numeric($stingator_import->{'NR. STING'}) ? $stingator_import->{'NR. STING'} : 0;
                        break;
                    case '':
                        // Nu se face nimic
                        break;
                    default:
                        // dd($stingator_import);
                        echo $iteratie . '. ' . 'Stingatoare: ' . $stingator_import->{'TIP STING.'} . '<br>';
                        break;
                }
                // echo strtolower($stingator_import->{'TIP STING.'}) . '<br><br>';
            }

            // Creare data expirare
            if (is_numeric($stingator_import->{'LUNA'}) && is_numeric($stingator_import->{'AN'})){
                $stingator->stingatoare_expirare = Carbon::create($stingator_import->{'AN'}, $stingator_import->{'LUNA'}, 1);
            }

            // Numarul total de stingatoare din excel, pentru verificare ulterioara
            $stingator->total = is_numeric($stingator_import->{'NR. STING'}) ? $stingator_import->{'NR. STING'} : 0;

            // Se incrementeaza iteratia
            $iteratie++;

            $stingator->save();
        }

        echo 'done final';
    }

    public function firmeDuplicat(){
        $firme = Firma::select('nume', 'cod_fiscal')
            ->get();

        foreach($firme->groupBy('nume') as $firme_grupate){
            if ($firme_grupate->count() > 1) {
                echo $firme_grupate->first()->nume . ' = ' . $firme_grupate->count();
                echo '<br>'  ;
            }
        }
    }

    public function totalIncorect(){
        $stingatoare = FirmaStingator::get();

        foreach($stingatoare as $stingator){
            if (
                    (
                        $stingator->p1 +
                        $stingator->p2 +
                        $stingator->p3 +
                        $stingator->p6 +
                        $stingator->p9 +
                        $stingator->sm6 +
                        $stingator->sm9 +
                        $stingator->p50 +
                        $stingator->p100 +
                        $stingator->sm50 +
                        $stingator->sm100 +
                        $stingator->g2 +
                        $stingator->g5
                    )
                !== $stingator->total)
            {
                    echo $stingator->id + 1;
                    echo '<br>'  ;
            }
        }
    }
}
