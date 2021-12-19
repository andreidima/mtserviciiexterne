<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\TematicaFisier;

use Illuminate\Support\Facades\Storage;

class TematicaFisierController extends Controller
{
    /**
     * Download files.
     *
     * @return \Illuminate\Http\Response
     */
    public function fileDownload(Request $request, TematicaFisier $fisier)
    {
        return Storage::disk('public')->download($fisier->fisier_cale . $fisier->fisier_nume);
    }
}
