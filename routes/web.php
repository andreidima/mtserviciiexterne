<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FirmaController;
use App\Http\Controllers\FirmaSalariatController;
use App\Http\Controllers\FirmaStingatorController;
use App\Http\Controllers\FirmaTraseuController;
use App\Http\Controllers\TematicaController;
use App\Http\Controllers\TematicaFisierController;
use App\Http\Controllers\ObservatieController;
use App\Http\Controllers\ObservatiePozaController;
use App\Http\Controllers\RaportController;

use App\Http\Controllers\MedicinaMunciiController;

use App\Http\Controllers\ImportInitialFisierExcelController;
use App\Http\Controllers\ImportInitialStingatoareFisierExcelController;
use App\Http\Controllers\ImportInitialMedicinaMunciiFisierExcelController;

use App\Http\Controllers\SsmFirmaController;
use App\Http\Controllers\SsmSalariatController;
use App\Http\Controllers\SsmRaportController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes(['register' => false, 'password.request' => false, 'reset' => false]);

Route::redirect('/', '/acasa');

Route::group(['middleware' => 'auth'], function () {
    Route::view('/acasa', 'acasa');

    Route::resource('/firme/salariati', FirmaSalariatController::class,  ['parameters' => ['salariati' => 'salariat']]);
    // Route::resource('/firme/stingatoare', FirmaStingatorController::class,  ['parameters' => ['stingatoare' => 'stingator']]);

    // Route::get('/firme/trasee/adauga-firma', [FirmaTraseuController::class, 'traseuAdaugaFirma']);
    Route::resource('/firme/trasee', FirmaTraseuController::class,  ['parameters' => ['trasee' => 'traseu']]);

    Route::resource('/firme', FirmaController::class,  ['parameters' => ['firme' => 'firma']]);

    Route::get('/tematici/file-download/{fisier}', [TematicaFisierController::class, 'fileDownload']);
    Route::resource('/tematici/fisiere', TematicaFisierController::class,  ['parameters' => ['fisiere' => 'fisier']]);

    Route::get('/tematici/firme-tematici', [TematicaController::class, 'firmeTematici']);
    Route::get('/tematici/firme-tematici/{firma}/tematici-modifica', [TematicaController::class, 'firmeTematiciModifica']);
    Route::post('/tematici/firme-tematici/{firma}/tematici-modifica', [TematicaController::class, 'postFirmeTematiciModifica']);

    Route::get('/tematici/salariati-tematici', [TematicaController::class, 'salariatiTematici']);
    Route::get('/tematici/salariati-tematici/{salariat}/tematici-modifica', [TematicaController::class, 'salariatiTematiciModifica']);
    Route::post('/tematici/salariati-tematici/{salariat}/tematici-modifica', [TematicaController::class, 'postSalariatiTematiciModifica']);

    Route::resource('/tematici', TematicaController::class,  ['parameters' => ['tematici' => 'tematica']]);


    Route::get('/observatii/file-download/{poza}', [ObservatiePozaController::class, 'fileDownload']);
    Route::resource('/observatii/poze', ObservatiePozaController::class,  ['parameters' => ['poze' => 'poza']]);
    Route::patch('/observatii/{observatie}/trimite-email', [ObservatieController::class, 'trimiteEmail']);
    Route::resource('/observatii', ObservatieController::class,  ['parameters' => ['observatii' => 'observatie']]);


    Route::get('/rapoarte/medicina-muncii', [RaportController::class, 'medicinaMuncii']);
    Route::get('/rapoarte/medicina-muncii/nr-de-inregistrare', [MedicinaMunciiController::class, 'numarInregistare']);
    Route::get('/rapoarte/medicina-muncii/{search_data}/{view_type}', [RaportController::class, 'medicinaMunciiExportPDF']);
    Route::get('/rapoarte/stingatoare', [RaportController::class, 'stingatoare']);
    Route::get('/rapoarte/stingatoare/{search_data}/{view_type}', [RaportController::class, 'stingatoareExportPDF']);
    Route::get('/rapoarte/hidranti', [RaportController::class, 'hidranti']);
    Route::get('/rapoarte/hidranti/{search_data}/{view_type}', [RaportController::class, 'hidrantiExportPDF']);
    Route::get('/rapoarte/instructaj', [RaportController::class, 'instructaj']);


    // SSM-ul construit total separat
    Route::resource('/ssm/firme', SsmFirmaController::class,  ['parameters' => ['firme' => 'firma']]);
    Route::get('/ssm/salariati/{salariat}/duplica', [SsmSalariatController::class, 'duplica']);
    Route::post('/ssm/salariati/axios-modificare-salariati-direct-din-index', [SsmSalariatController::class, 'axiosModificareSalariatiDirectDinIndex']);
    Route::resource('/ssm/salariati', SsmSalariatController::class,  ['parameters' => ['salariati' => 'salariat']]);
    // Route::get('/ssm/salariati-modifica-selectati', [SsmSalariatController::class, 'modificaSelectati']);
    Route::post('/ssm/salariati-modifica-selectati', [SsmSalariatController::class, 'modificaSelectati']);

    Route::get('/ssm/rapoarte/firme', [SsmRaportController::class, 'firme']);
    Route::get('/ssm/rapoarte/firme/{ssm_luna}/{psi_luna}/{view_type}', [SsmRaportController::class, 'firmeExportPDF']);
    Route::get('/ssm/rapoarte/salariati/{deRezolvat?}', [SsmRaportController::class, 'salariati']);
    Route::get('/ssm/rapoarte/salariati/{data_ssm_psi}/{semnat_ssm}/{semnat_psi}/{view_type}', [SsmRaportController::class, 'salariatiExportPDF']);

    // Rute pentru doamna de la Medicina Muncii, sa poata cauta in datele de la SSM
    Route::get('/ssm/rapoarte-pentru-medicina-muncii/firme', [SsmRaportController::class, 'medicinaMunciiFirme']);
    Route::get('/ssm/rapoarte-pentru-medicina-muncii/salariati', [SsmRaportController::class, 'medicinaMunciiSalariati']);
    Route::get('/ssm/rapoarte-pentru-medicina-muncii/salariati/{view_type}', [SsmRaportController::class, 'medicinaMunciiSalariatiExportPdf']);


    // Reconstructie totala a rutelor - firme separate pentru SSM, Medicina muncii, Stingatoare
    // SSM-ul a fost construit total separat pana la urma
    Route::resource('/{serviciu}/firme/trasee', FirmaTraseuController::class,  ['parameters' => ['trasee' => 'traseu']]);

    Route::resource('/{serviciu}/firme/{firma_curenta}/salariati', FirmaSalariatController::class,  ['parameters' => ['salariati' => 'salariat']]);
    Route::resource('/{serviciu}/firme/{firma}/stingatoare', FirmaStingatorController::class,  ['parameters' => ['stingatoare' => 'stingator']]);
    Route::resource('/{serviciu}/firme', FirmaController::class,  ['parameters' => ['firme' => 'firma']]);


    // A fost introdus Nr. Crt. pentru Anca, pentru un mai bun control al sortarii salariatilor de la SSM
    // A fost setat Nr. Crt. default 0, iar apoi i s-a dat fiecarui salariat o valoare, in functie de cum a avut nevoie Anca
    // Data 2023.08.05
    Route::get('/setarea-nr-crt-initiala-din-cod', function(){
        $salariati = App\Models\SsmSalariat::
                        orderBy('nume_client')
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
                        ->orderBy('salariat')
                        ->get();
        foreach($salariati->groupBy('nume_client') as $salariatiGrupatiDupaNumeClient){
            $nrCrt = 1;
            // if ($salariatiGrupatiDupaNumeClient->first()->nume_client === 'AGROTRANS COMPANY'){
                foreach ($salariatiGrupatiDupaNumeClient as $salariat){
                    // $salariat->nr_crt = $nrCrt++;
                    // $salariat0>save();
                    // echo $salariat->nume;

                    $salariat->update(['nr_crt' => $nrCrt++]);
                }
            // }
        }

        return('hi');

    });






    // Route::get('merge-medicina-muncii', function(){
    //     \App\Models\SsmSalariat::where('id', '>' , 0)
    //         ->update(['med_muncii' => NULL]);

    //     \App\Models\SsmSalariat::
    //         where([
    //             ['med_muncii_zi', '<>', NULL],
    //             ['med_muncii_zi', '<>', '-']
    //         ])
    //         ->orwhere([
    //             ['med_muncii_luna', '<>', NULL],
    //             ['med_muncii_luna', '<>', '-']
    //         ])
    //         ->orwhere([
    //             ['med_muncii_an', '<>', NULL],
    //             ['med_muncii_an', '<>', '-']
    //         ])
    //         ->update(['med_muncii' => DB::raw("concat(med_muncii_zi, '.', med_muncii_luna, '.', med_muncii_an)")]);
    //     echo 'Hi';
    // });


    // Import initial SSM
    // Route::get('/import/verificare-salariati-firme-dupa-cnp', [ImportInitialFisierExcelController::class, 'importFirmeVerificaDupaCNP']);
    // Route::get('/import/import-salariati', [ImportInitialFisierExcelController::class, 'importSalariati']);


    // Route::get('/import/import-firme', [ImportInitialFisierExcelController::class, 'importFirme']);

    // Import Medicina Muncii
    // Route::get('/import/import-medicina-muncii', [ImportInitialMedicinaMunciiFisierExcelController::class, 'importMedicinaMuncii']);

    // Import stingatoare
    // Route::get('/import/import-stingatoare', [ImportInitialStingatoareFisierExcelController::class, 'importStingatoare']);
    // Erori dupa import
    // Route::get('/total-incorect', [ImportInitialStingatoareFisierExcelController::class, 'totalIncorect']);
    // Erori dupa import
    // Route::get('/firme-duplicat', [ImportInitialStingatoareFisierExcelController::class, 'firmeDuplicat']);
});
