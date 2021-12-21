<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ObservatiePoza;

use Illuminate\Support\Facades\Storage;

class ObservatiePozaController extends Controller
{

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ObservatiePoza  $poza
     * @return \Illuminate\Http\Response
     */
    public function destroy(ObservatiePoza $poza)
    {
        // Stergere din baza de date
        $poza->delete();

        // Stergere poza
        Storage::delete($poza->cale . $poza->nume);

        // Stergere director daca acesta este gol
        if (empty(Storage::allFiles($poza->cale))) {
            Storage::deleteDirectory($poza->cale);
        }

        return back()->with('status', 'Poza "' . $poza->nume . '" a fost ștearsă cu succes!');
    }

    /**
     * Download files.
     *
     * @return \Illuminate\Http\Response
     */
    public function fileDownload(Request $request, ObservatiePoza $poza)
    {
        return Storage::disk('public')->download($poza->cale . $poza->nume);
    }
}
