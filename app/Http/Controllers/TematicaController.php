<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Models\Tematica;
use App\Models\TematicaFisier;
use App\Models\Firma;
use App\Models\FirmaSalariat;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class TematicaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_nume = \Request::get('search_nume');

        $tematici = Tematica::
            when($search_nume, function ($query, $search_nume) {
                return $query->where('nume', 'like', '%' . $search_nume . '%');
            })
            ->latest()
            ->simplePaginate(25);

        return view('tematici.index', compact('tematici', 'search_nume'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tematici.create');
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
        $tematica = Tematica::create($request->except(['fisiere']));

        if($request->hasfile('fisiere')) {
            foreach ($request->file('fisiere') as $fisier) {
                $nume = $fisier->getClientOriginalName();
                $cale = 'app/uploads/tematici/' . $tematica->id . '/';

                if (Storage::exists($cale.$nume)){
                    return back()->with('error', 'Fișierul ' . $nume . ' este deja încărcat la această tematică');
                }

                Storage::makeDirectory($cale);

                $fisier->move(storage_path($cale), $nume);

                $fisier = new TematicaFisier;
                $fisier->tematica_id = $tematica->id;
                $fisier->nume = $nume;
                $fisier->cale = $cale;
                $fisier->user_id = $request->user()->id;
                $fisier->save();
            }
        }

        return redirect('/tematici')->with('status', 'Tematica „' . ($tematica->nume ?? '') . '” a fost adăugată cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tematica  $tematica
     * @return \Illuminate\Http\Response
     */
    public function show(Tematica $tematica)
    {
        return view('tematici.show', compact('tematica'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tematica  $tematica
     * @return \Illuminate\Http\Response
     */
    public function edit(Tematica $tematica)
    {
        return view('tematici.edit', compact('tematica'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tematica  $tematica
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tematica $tematica)
    {
        $request->request->add(['user_id' => $request->user()->id]);

        $this->validateRequest($request);
        $tematica->update($request->except(['fisiere']));

        if($request->hasfile('fisiere')) {
            foreach ($request->file('fisiere') as $fisier) {
                $nume = $fisier->getClientOriginalName();
                $cale = 'app/uploads/tematici/' . $tematica->id . '/';

                if (Storage::exists($cale.$nume)){
                    return back()->with('error', 'Fișierul ' . $nume . ' este deja încărcat la această tematică');
                }

                Storage::makeDirectory($cale);

                $fisier->move(storage_path($cale), $nume);

                $fisier = new TematicaFisier;
                $fisier->tematica_id = $tematica->id;
                $fisier->nume = $nume;
                $fisier->cale = $cale;
                $fisier->user_id = $request->user()->id;
                $fisier->save();
            }
        }

        return redirect('/tematici')->with('status', 'Tematica „' . ($tematica->nume ?? '') . '” a fost modificată cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tematica  $tematica
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tematica $tematica)
    {
        if (count($tematica->fisiere)){
            return back()->with('error', 'Tematica „' . ($tematica->nume ?? '') . '” nu poate fi ștearsă pentru că are fișiere adăugate. Ștergeti mai întâi fișierele de la această tematica');
        }

        $tematica->delete();

        return redirect('/tematici')->with('status', 'Tematica „' . ($tematica->nume ?? '') . '” a fost ștearsă cu succes!');
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
                'nume' => 'required|max:500',
                'tip' => 'nullable|numeric|integer|min:0|max:1',
                'descriere' => 'nullable|max:2000',
                'observatii' => 'nullable|max:2000',
                'user_id' => 'required',
                'fisiere.*' => 'nullable|mimes:jpg,jpeg,png,gif,doc,docx,pdf|max:30000'
            ],
            [

            ]
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function firmeTematici()
    {
        $search_nume = \Request::get('search_nume');

        $firme = Firma::with('tematici')
            ->when($search_nume, function ($query, $search_nume) {
                return $query->where('nume', 'like', '%' . $search_nume . '%');
            })
            ->orderBy('updated_at', 'DESC')
            ->simplePaginate(25);

        return view('tematici/diverse/firmeTematici', compact('firme', 'search_nume'));
    }

    /**
     * Incarca formularul cu tematici pentru firma aleasa
     *
     * @return \Illuminate\Http\Response
     */
    public function firmeTematiciModifica(Firma $firma)
    {
        $tematici = Tematica::select('id', 'nume')
            // ->where('tip', 0)  // extragere doar a tematicilor su
            ->get();

        return view('tematici.diverse.firmeTematiciModifica', compact('firma', 'tematici'));
    }

    /**
     * Modificarea tematicilor unei firme
     */
    public function postFirmeTematiciModifica(Request $request, Firma $firma)
    {
        $firma->tematici()->sync($request->input('tematici_selectate'));
        $firma->updated_at = \Carbon\Carbon::now();
        $firma->save();

        return redirect('/tematici/firme-tematici')->with('status', 'Tematicile pentru firma „' . ($firma->nume ?? '') . '” au fost modificate cu succes!');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function salariatiTematici()
    {
        $search_nume = \Request::get('search_nume');
        $search_firma = \Request::get('search_firma');

        $salariati = FirmaSalariat::with('tematici', 'firma')
            ->when($search_nume, function ($query, $search_nume) {
                return $query->where('nume', 'like', '%' . $search_nume . '%');
            })
            ->when($search_firma, function (Builder $query) use ($search_firma) {
                $query->whereHas('firma', function (Builder $query) use ($search_firma) {
                    $query->where('nume', 'like', '%' . $search_firma . '%');
                });
            })
            ->orderBy('updated_at', 'DESC')
            ->simplePaginate(25);

        return view('tematici/diverse/salariatiTematici', compact('salariati', 'search_nume', 'search_firma'));
    }

    /**
     * Incarca formularul cu tematici pentru salariatu ales
     *
     * @return \Illuminate\Http\Response
     */
    public function salariatiTematiciModifica(FirmaSalariat $salariat)
    {
        $tematici = Tematica::select('id', 'nume')
            // ->where('tip', 1)   // extragere doar a tematicilor ssm
            ->get();

        return view('tematici.diverse.salariatiTematiciModifica', compact('salariat', 'tematici'));
    }

    /**
     * Modificarea tematicilor unui salariat
     */
    public function postSalariatiTematiciModifica(Request $request, FirmaSalariat $salariat)
    {
        $salariat->tematici()->sync($request->input('tematici_selectate'));
        $salariat->updated_at = \Carbon\Carbon::now();
        $salariat->save();

        return redirect('/tematici/salariati-tematici')->with('status', 'Tematicile pentru salariatul „' . ($salariat->nume ?? '') . '” au fost modificate cu succes!');
    }
}
