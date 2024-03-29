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
    public function index($serviciu = null)
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

        $request->session()->forget('stingatoare_return_url');

        return view('firme.stingatoare.index', compact('stingatoare', 'search_nume'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $serviciu = null, Firma $firma)
    {
        $request->session()->get('stingatoare_return_url') ?? $request->session()->put('stingatoare_return_url', url()->previous());

        return view('firme.stingatoare.create', compact('serviciu', 'firma'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $serviciu = null)
    {
        $request->request->add(['user_id' => $request->user()->id]);
        $stingator = FirmaStingator::create($this->validateRequest($request));

        return redirect($request->session()->get('stingatoare_return_url') ?? ('/' . $serviciu . '/firme'))
            ->with('status', 'Stingătoarele pentru firma „' . ($stingator->firma->nume ?? '') . '” au fost adăugate cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FirmaStingator  $stingator
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $serviciu = null, FirmaStingator $stingator)
    {
        $request->session()->get('stingatoare_return_url') ?? $request->session()->put('stingatoare_return_url', url()->previous());

        return view('firme.stingatoare.show', compact('stingator'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FirmaStingator  $stingator
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $serviciu = null, Firma $firma, FirmaStingator $stingator)
    {
        $request->session()->get('stingatoare_return_url') ?? $request->session()->put('stingatoare_return_url', url()->previous());

        return view('firme.stingatoare.edit', compact('serviciu', 'stingator', 'firma'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FirmaStingator  $stingator
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $serviciu = null, Firma $firma, FirmaStingator $stingator)
    {
        $request->request->add(['user_id' => $request->user()->id]);
        $this->validateRequest($request);
        // dd($request, $stingator);
        $stingator->update($this->validateRequest($request));

        return redirect($request->session()->get('stingatoare_return_url') ?? ('/' . $serviciu . '/firme'))
            ->with('status', 'Stingătoarele pentru firma „' . ($stingator->firma->nume ?? '') . '” au fost modificate cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FirmaStingator  $stingator
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $serviciu = null, Firma $firma, FirmaStingator $stingator)
    {
        $stingator->delete();

        return back()->with('status', 'Stingătoarele pentru firma „' . ($stingator->firma->nume ?? '') . '” au fost șterse cu succes!');
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
                'p1' => 'nullable|numeric|integer|min:0|max:999',
                'p2' => 'nullable|numeric|integer|min:0|max:999',
                'p3' => 'nullable|numeric|integer|min:0|max:999',
                'p4' => 'nullable|numeric|integer|min:0|max:999',
                'p5' => 'nullable|numeric|integer|min:0|max:999',
                'p6' => 'nullable|numeric|integer|min:0|max:999',
                'p9' => 'nullable|numeric|integer|min:0|max:999',
                // 'p12' => 'nullable|numeric|integer|min:0|max:999',
                'p50' => 'nullable|numeric|integer|min:0|max:999',
                'p100' => 'nullable|numeric|integer|min:0|max:999',
                'sm3' => 'nullable|numeric|integer|min:0|max:999',
                'sm6' => 'nullable|numeric|integer|min:0|max:999',
                'sm9' => 'nullable|numeric|integer|min:0|max:999',
                'sm50' => 'nullable|numeric|integer|min:0|max:999',
                'sm100' => 'nullable|numeric|integer|min:0|max:999',
                'g2' => 'nullable|numeric|integer|min:0|max:999',
                'g5' => 'nullable|numeric|integer|min:0|max:999',
                'stingatoare_expirare' => 'nullable|date',
                'hidranti' => 'nullable|numeric|integer|min:0|max:999',
                'hidranti_expirare' => 'nullable|date',
                'observatii' => 'nullable|max:2000',
                'user_id' => 'required',
            ],
            [

            ]
        );
    }
}
