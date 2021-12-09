<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CarteScanataController;

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

    Route::resource('/carti-scanate', CarteScanataController::class,  ['parameters' => ['carti-scanate' => 'carte_scanata']]);
});
