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
use App\Http\Controllers\ImportInitialFisierExcelController;

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
    Route::resource('/firme/stingatoare', FirmaStingatorController::class,  ['parameters' => ['stingatoare' => 'stingator']]);

    Route::get('/firme/trasee/adauga-firma', [FirmaTraseuController::class, 'traseuAdaugaFirma']);
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

    Route::get('/rapoarte/stingatoare', [RaportController::class, 'stingatoare']);
    Route::get('/rapoarte/instructaj', [RaportController::class, 'instructaj']);
    Route::get('/rapoarte/medicina-muncii', [RaportController::class, 'medicinaMuncii']);

    Route::get('teste', function(){
        // if (\App\Models\Firma::whereDoesntHave('stingator')->inRandomOrder()->first()){
        //     return \App\Models\Firma::whereDoesntHave('stingator')->inRandomOrder()->first()->id;
        // }
        //     return 'nimic';
    });

    Route::get('/import/import-firme', [ImportInitialFisierExcelController::class, 'importFirme']);
    Route::get('/import/import-salariati', [ImportInitialFisierExcelController::class, 'importSalariati']);
});
