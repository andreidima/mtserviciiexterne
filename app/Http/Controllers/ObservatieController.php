<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Models\Observatie;
use App\Models\ObservatiePoza;
use App\Models\SsmFirma;
use App\Mail\ObservatieFirma;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use Image;

class ObservatieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_nume = \Request::get('search_nume');
        $search_firma = \Request::get('search_firma');

        $observatii = Observatie::with('firma')
            ->when($search_nume, function ($query, $search_nume) {
                return $query->where('nume', 'like', '%' . $search_nume . '%');
            })
            ->when($search_firma, function (Builder $query) use ($search_firma) {
                $query->whereHas('firma', function (Builder $query) use ($search_firma) {
                    $query->where('nume', 'like', '%' . $search_firma . '%');
                });
            })
            ->latest()
            ->simplePaginate(25);

        return view('observatii.index', compact('observatii', 'search_nume', 'search_firma'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $firme = SsmFirma::select('id', 'nume')->orderBy('nume')->get();

        return view('observatii.create', compact('firme'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->request->add(['user_id' => $request->user()->id]);

        $this->validateRequest($request);
        $observatie = Observatie::create(($request->except(['poze', 'date'])));

        if($request->hasfile('poze')) {
            $this->salvarePozeLaObservatie($request, $observatie);
        }

        return redirect('observatii')->with('status', 'Observația „' . ($observatie->nume ?? '') . '” a fost adăugată cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Observatie  $observatie
     * @return \Illuminate\Http\Response
     */
    public function show(Observatie $observatie)
    {
        return view('observatii.show', compact('observatie'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Observatie  $observatie
     * @return \Illuminate\Http\Response
     */
    public function edit(Observatie $observatie)
    {
        $firme = SsmFirma::select('id', 'nume')->orderBy('nume')->get();

        return view('observatii.edit', compact('observatie', 'firme'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Observatie  $observatie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Observatie $observatie)
    {
        $request->request->add(['user_id' => $request->user()->id]);

        $this->validateRequest($request);
        $observatie->update($request->except(['poze', 'date']));

        if($request->hasfile('poze')) {
            $this->salvarePozeLaObservatie($request, $observatie);
        }

        return redirect('observatii')->with('status', 'Observația „' . ($observatie->nume ?? '') . '” a fost modificată cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Observatie  $observatie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Observatie $observatie)
    {
        $observatie->delete();

        foreach ($observatie->poze as $poza){
            // Stergere din baza de date
            $poza->delete();

            // Stergere poza
            Storage::delete($poza->cale . $poza->nume);

            // Stergere director daca acesta este gol
            if (empty(Storage::allFiles($poza->cale))) {
                Storage::deleteDirectory($poza->cale);
            }
        }

        return redirect('observatii')->with('status', 'Observația „' . ($observatie->nume ?? '') . '” a fost ștearsă cu succes!');
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest(Request $request)
    {
        return $request->validate(
            [
                'firma_id' => 'required|numeric|integer',
                'nume' => 'required|max:500',
                'descriere' => 'nullable|max:2000',
                'data' => 'nullable|date',
                'email' => 'required|max:250|email:rfc,dns',
                'observatii_interne' => 'nullable|max:2000',
                'nr_trimiteri' => 'nullable|numeric|integer|min:0|max:250',
                'user_id' => 'nullable',
                'poze.*' => 'nullable|mimes:jpg,jpeg,png,gif|max:5000'
            ],
            [

            ]
        );
    }

    public function salvarePozeLaObservatie($request, $observatie)
    {
        foreach ($request->file('poze') as $poza) {
            $nume = $poza->getClientOriginalName();
            $cale = 'app/uploads/observatii/' . $observatie->id . '/';

            if (Storage::exists($cale.$nume)){
                return back()->with('error', 'Poza ' . $nume . ' este deja încărcată la această Observație');
            }

            Storage::makeDirectory($cale);

            // Prelucrarea pozei si salvarea pe hard-disk
            $imagine = Image::make($poza->path());
            $imagine->orientate(); // roteste imaginea ca sa se uploadeze in formatul ei initial (portret sau peisaj)
            $imagine->resize(1500, 1500, function ($const) {
                $const->aspectRatio();
            });
            $imagine->save(storage_path($cale . $nume));

            $poza = new ObservatiePoza;
            $poza->observatie_id = $observatie->id;
            $poza->nume = $nume;
            $poza->cale = $cale;
            $poza->user_id = $request->user()->id;
            $poza->save();
        }

    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function trimiteEmail(Request $request, Observatie $observatie)
    {
        // Verificare daca exista email FIRMA corect catre care sa se trimita mesajul.
        $validator = Validator::make($observatie->toArray(), [
            'email' => ['email:rfc,dns']
        ]);

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }

            \Mail::to($observatie->email)
                ->send(
                    new ObservatieFirma($observatie)
                );

            $observatie->nr_trimiteri ++;

            $observatie->save();

            return back()->with('status',
                'Emailul către firma „' . ($observatie->firma->nume ?? '') . '”, cu  observația „' . $observatie->nume . '”,
                    a fost trimis cu succes!');


    }
}
