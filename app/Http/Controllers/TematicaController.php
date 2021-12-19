<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Models\Tematica;
use App\Models\TematicaFisier;

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
                $cale = '/uploads/tematici/' . $tematica->id . '/';

                if (Storage::disk('public')->exists($cale.$nume)){
                    return back()->with('error', 'Fișierul ' . $nume . ' este deja încărcat la această tematică');
                }

                Storage::disk('public')->makeDirectory($cale);
                $fisier->move(public_path($cale), $nume);

                $fisier = new TematicaFisier;
                $fisier->tematica_id = $tematica->id;
                $fisier->fisier_nume = $nume;
                $fisier->fisier_cale = $cale;
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
                $cale = '/uploads/tematici/' . $tematica->id . '/';

                if (Storage::disk('public')->exists($cale.$nume)){
                    return back()->with('error', 'Fișierul ' . $nume . ' este deja încărcat la această tematică');
                }

                Storage::disk('public')->makeDirectory($cale);
                $fisier->move(public_path($cale), $nume);

                $fisier = new TematicaFisier;
                $fisier->tematica_id = $tematica->id;
                $fisier->fisier_nume = $nume;
                $fisier->fisier_cale = $cale;
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
                'descriere' => 'nullable|max:2000',
                'observatii' => 'nullable|max:2000',
                'user_id' => 'required',
                'fisiere.*' => 'nullable|mimes:jpg,jpeg,png,gif,doc,docx,pdf|max:30000'
            ],
            [

            ]
        );
    }
}
