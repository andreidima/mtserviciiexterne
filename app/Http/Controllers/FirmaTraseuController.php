<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Models\FirmaTraseu;
use App\Models\Firma;

use Illuminate\Database\Eloquent\Builder;

class FirmaTraseuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $serviciu = null)
    {
        $search_nume = \Request::get('search_nume');
        $search_firma = \Request::get('search_firma');

        $trasee = FirmaTraseu::
            where (function($query) use ($serviciu) {
                switch ($serviciu) {
                    case 'ssm':
                        $query->where('serviciu', 1);
                        break;
                    case 'stingatoare':
                        $query->where('serviciu', 2);
                        break;
                    default:
                        # code...
                        break;
                }
            })
            ->with('firme')
            ->when($search_nume, function ($query, $search_nume) {
                return $query->where('nume', 'like', '%' . $search_nume . '%');
            })
            ->when($search_firma, function (Builder $query) use ($search_firma) {
                $query->whereHas('firme', function (Builder $query) use ($search_firma) {
                    $query->where('nume', 'like', '%' . $search_firma . '%');
                });
            })
            ->latest()
            ->simplePaginate(25);

        $request->session()->forget('traseu_return_url');

        return view('firme.trasee.index', compact('serviciu', 'trasee', 'search_nume', 'search_firma'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $serviciu = null)
    {
        $request->session()->get('traseu_return_url') ?? $request->session()->put('traseu_return_url', url()->previous());

        return view('firme.trasee.create', compact('serviciu'));
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
        $traseu = FirmaTraseu::create($this->validateRequest($request, $serviciu));

        return redirect($request->session()->get('traseu_return_url') ?? ('/' . $serviciu . '/firme/trasee'))
            ->with('status', 'Traseul „' . ($traseu->nume ?? '') . '” a fost adăugat cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FirmaTraseu  $traseu
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $serviciu = null, FirmaTraseu $traseu)
    {
        $request->session()->get('traseu_return_url') ?? $request->session()->put('traseu_return_url', url()->previous());

        return view('firme.trasee.show', compact('traseu', 'serviciu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FirmaTraseu  $traseu
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $serviciu = null, FirmaTraseu $traseu)
    {
        $request->session()->get('traseu_return_url') ?? $request->session()->put('traseu_return_url', url()->previous());

        return view('firme.trasee.edit', compact('traseu', 'serviciu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FirmaTraseu  $traseu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $serviciu = null, FirmaTraseu $traseu)
    {
        $request->request->add(['user_id' => $request->user()->id]);
        $traseu->update($this->validateRequest($request));

        return redirect($request->session()->get('traseu_return_url') ?? ('/' . $serviciu . '/firme/trasee'))
            ->with('status', 'Traseul „' . ($traseu->nume ?? '') . '” a fost modificat cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FirmaTraseu  $traseu
     * @return \Illuminate\Http\Response
     */
    public function destroy($serviciu = null, FirmaTraseu $traseu)
    {
        if (count($traseu->firme)){
            return back()->with('error', 'Traseul „' . ($traseu->nume ?? '') . '” nu poate fi șters pentru că are firme adăugate. Scoateți mai întâi firmele de pe acest traseu');
        }

        $traseu->delete();

        // return redirect('/firme/trasee')->with('status', 'Traseul „' . ($traseu->nume ?? '') . '” a fost șters cu succes!');
        return back()->with('status', 'Traseul „' . ($traseu->nume ?? '') . '” a fost șters cu succes!');
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest(Request $request, $serviciu = null)
    {
        switch ($serviciu) {
            case 'ssm':
                $request->request->add(['serviciu' => 1]);
                break;
            case 'stingatoare':
                $request->request->add(['serviciu' => 2]);
                break;
            default:
                # code...
                break;
            }

        return $request->validate(
            [
                'nume' => 'required|max:500',
                'observatii' => 'nullable|max:2000',
                'serviciu' => '',
                'user_id' => 'required',
            ],
            [

            ]
        );
    }
}
