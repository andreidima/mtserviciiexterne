<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\TematicaFisier;

use Illuminate\Support\Facades\Storage;

class TematicaFisierController extends Controller
{

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TematicaFisier  $fisier
     * @return \Illuminate\Http\Response
     */
    public function destroy(TematicaFisier $fisier)
    {
        // Stergere fisier
        Storage::delete($fisier->cale . $fisier->nume);

        // Stergere director daca acesta este gol
        if (empty(Storage::allFiles($fisier->cale))) {
            Storage::deleteDirectory($fisier->cale);
        }

        // Stergere din baza de date
        $fisier->delete();

        return back()->with('status', 'Fișierul "' . $fisier->nume . '" a fost șters cu succes!');
    }

    /**
     * Download files.
     *
     * @return \Illuminate\Http\Response
     */
    public function fileDownload(Request $request, TematicaFisier $fisier)
    {
        return Storage::disk('public')->download($fisier->cale . $fisier->nume);
    }
}
