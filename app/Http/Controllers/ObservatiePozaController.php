<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

use App\Models\ObservatiePoza;

use Illuminate\Support\Facades\Storage;

class ObservatiePozaController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\ObservatiePoza  $poza
     * @return \Illuminate\Http\Response
     */
    public function show(ObservatiePoza $poza)
    {
        //This method will look for the file and get it from drive
        $path = storage_path($poza->cale . $poza->nume);
        try {
            $file = File::get($path);
            $type = File::mimeType($path);
            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);
            return $response;
        } catch (FileNotFoundException $exception) {
            abort(404);
        }
        // return view('observatii.show', compact('observatie'));
    }

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
        return Storage::download($poza->cale . $poza->nume);
    }
}
