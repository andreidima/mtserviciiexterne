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

class ImportInitialMedicinaMunciiFisierExcelController extends Controller
{
    public function importMedicinaMuncii()
    {
        $salariati_import = DB::table('import_medicina_muncii')->get();

        foreach ($salariati_import as $salariat_import){
            $salariat = new FirmaSalariat;

            //Firma
            if ($salariat_import->{'ANGAJATOR'}){
                $firma = Firma::firstOrCreate(
                    [
                        'nume' => $salariat_import->{'ANGAJATOR'},
                    ],
                );
                if (!isset($firma->localitate)){
                    $firma->localitate = $salariat_import->{'ADRESA ANGAJATOR'};
                    $firma->medicina_muncii_serviciu = 1;
                    $firma->save();
                }
            }

            $salariat->firma_id = $firma->id;
            $salariat->nume = $salariat_import->{'NUME PACIENT'};
            $salariat->cnp = $salariat_import->{'CNP'};
            $salariat->functie = $salariat_import->{'OBSERVATII'};
            $salariat->observatii = $salariat_import->{'DATE CONTACT'};
            if (strtotime($salariat_import->{'DATA examinarii'})) {
                $salariat->medicina_muncii_examinare = Carbon::parse($salariat_import->{'DATA examinarii'});
            }
            if (strtotime($salariat_import->{'DATA urm.exam.'})) {
                $salariat->medicina_muncii_expirare = Carbon::parse($salariat_import->{'DATA urm.exam.'});
            }

            $salariat->save();
        }
        echo 'done final';
    }
}
