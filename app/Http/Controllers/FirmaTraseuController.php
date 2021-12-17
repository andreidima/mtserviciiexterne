<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Models\FirmaTraseu;
use App\Models\Firma;

class FirmaTraseuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_nume = \Request::get('search_nume');

        $trasee = FirmaTraseu::
            with(['firme' => function ($query) {
                $query->orderBy('traseu_ordine');
            }])
            ->when($search_nume, function ($query, $search_nume) {
                return $query->where('nume', 'like', '%' . $search_nume . '%');
            })
            ->latest()
            ->simplePaginate(25);

        return view('firme.trasee.index', compact('trasee', 'search_nume'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('firme.trasee.create');
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
        $traseu = FirmaTraseu::create($this->validateRequest($request));

        return redirect('/firme/trasee')->with('status', 'Traseul „' . ($traseu->nume ?? '') . '” a fost adăugat cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FirmaTraseu  $traseu
     * @return \Illuminate\Http\Response
     */
    public function show(FirmaTraseu $traseu)
    {
        return view('firme.trasee.show', compact('traseu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FirmaTraseu  $traseu
     * @return \Illuminate\Http\Response
     */
    public function edit(FirmaTraseu $traseu)
    {
        return view('firme.trasee.edit', compact('traseu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FirmaTraseu  $traseu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FirmaTraseu $traseu)
    {
        $request->request->add(['user_id' => $request->user()->id]);
        $traseu->update($this->validateRequest($request));

        return redirect('/firme/trasee')->with('status', 'Traseul „' . ($traseu->nume ?? '') . '” a fost modificat cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FirmaTraseu  $traseu
     * @return \Illuminate\Http\Response
     */
    public function destroy(FirmaTraseu $traseu)
    {
        if (count($traseu->firme)){
            return back()->with('error', 'Traseul „' . ($traseu->nume ?? '') . '” nu poate fi șters pentru că are firme adăugate. Scoateți mai întâi firmele de pe acest traseu');
        }

        $traseu->delete();

        return redirect('/firme/trasee')->with('status', 'Traseul „' . ($traseu->nume ?? '') . '” a fost șters cu succes!');
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
                'observatii' => 'nullable|max:2000',
                'user_id' => 'required',
            ],
            [

            ]
        );
    }
}
