<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Models\FirmaStingator;
use App\Models\Firma;

use Illuminate\Database\Eloquent\Builder;

class FirmaStingatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_nume = \Request::get('search_nume');

        $stingatoare = FirmaStingator::with('firma')
            ->when($search_nume, function (Builder $query) use ($search_nume) {
                $query->whereHas('firma', function (Builder $query) use ($search_nume) {
                    $query->where('nume', 'like', '%' . $search_nume . '%');
                });
            })
            ->latest()
            ->simplePaginate(25);

        return view('firme.stingatoare.index', compact('stingatoare', 'search_nume'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $firme = Firma::doesntHave('stingator')->orderBy('nume')->get();

        return view('firme.stingatoare.create', compact('firme'));
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
        $stingator = FirmaStingator::create($this->validateRequest($request));

        return redirect('/firme/stingatoare')->with('status', 'Stingătoarele pentru firma „' . ($stingator->firma->nume ?? '') . '” au fost adăugate cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FirmaStingator  $stingator
     * @return \Illuminate\Http\Response
     */
    public function show(FirmaStingator $stingator)
    {
        return view('firme.stingatoare.show', compact('stingator'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FirmaStingator  $stingator
     * @return \Illuminate\Http\Response
     */
    public function edit(FirmaStingator $stingator)
    {
        $firme = Firma::doesntHave('stingator')
            ->orWhere('id', '=', $stingator->firma_id)
            ->orderBy('nume')->get();

        return view('firme.stingatoare.edit', compact('stingator', 'firme'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FirmaStingator  $stingator
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FirmaStingator $stingator)
    {
        $request->request->add(['user_id' => $request->user()->id]);
        $stingator->update($this->validateRequest($request));

        return redirect('/firme/stingatoare')->with('status', 'Stingătoarele pentru firma „' . ($stingator->firma->nume ?? '') . '” au fost modificate cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FirmaStingator  $stingator
     * @return \Illuminate\Http\Response
     */
    public function destroy(FirmaStingator $stingator)
    {
        $stingator->delete();

        return redirect('/firme/stingatoare')->with('status', 'Stingătoarele pentru firma „' . ($stingator->firma->nume ?? '') . '” au fost șterse cu succes!');
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
                'firma_id' => 'nullable|numeric|integer',
                'p1' => 'nullable|numeric|integer|min:0|max:65000',
                'p2' => 'nullable|numeric|integer|min:0|max:65000',
                'p3' => 'nullable|numeric|integer|min:0|max:65000',
                'p6' => 'nullable|numeric|integer|min:0|max:65000',
                'p9' => 'nullable|numeric|integer|min:0|max:65000',
                'sm6' => 'nullable|numeric|integer|min:0|max:65000',
                'sm9' => 'nullable|numeric|integer|min:0|max:65000',
                'p50' => 'nullable|numeric|integer|min:0|max:65000',
                'p100' => 'nullable|numeric|integer|min:0|max:65000',
                'sm50' => 'nullable|numeric|integer|min:0|max:65000',
                'sm100' => 'nullable|numeric|integer|min:0|max:65000',
                'g2' => 'nullable|numeric|integer|min:0|max:65000',
                'g5' => 'nullable|numeric|integer|min:0|max:65000',
                'stingatoare_expirare' => 'nullable|date',
                // 'hidranti_expirare' => 'nullable|date',
                'observatii' => 'nullable|max:2000',
                'user_id' => 'required',
            ],
            [

            ]
        );
    }
}
