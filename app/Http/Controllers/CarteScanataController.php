<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Models\CarteScanata;

class CarteScanataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_titlu = \Request::get('search_titlu');

        $carti_scanate = CarteScanata::with('utilizator')
            ->when($search_titlu, function ($query, $search_titlu) {
                return $query->where('titlu', 'like', '%' . $search_titlu . '%');
            })
            ->latest()
            ->simplePaginate(25);
// dd($carti_scanate->first());

        return view('carti_scanate.index', compact('carti_scanate', 'search_titlu'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('carti_scanate.create');
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
        $carte_scanata = CarteScanata::create($this->validateRequest($request));

        return redirect('/carti-scanate')->with('status', 'Cartea „' . ($carte_scanata->titlu ?? '') . '” a fost adăugată cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CarteScanata  $carte_scanata
     * @return \Illuminate\Http\Response
     */
    public function show(CarteScanata $carte_scanata)
    {
        return view('carti_scanate.show', compact('carte_scanata'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CarteScanata  $carte_scanata
     * @return \Illuminate\Http\Response
     */
    public function edit(CarteScanata $carte_scanata)
    {
        if (Gate::denies('modifica-carte-scanata', $carte_scanata)) {
            abort(403);
        }

        return view('carti_scanate.edit', compact('carte_scanata'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CarteScanata  $carte_scanata
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CarteScanata $carte_scanata)
    {
        if (Gate::denies('modifica-carte-scanata', $carte_scanata)) {
            abort(403);
        }

        $request->request->add(['user_id' => $request->user()->id]);
        $carte_scanata->update($this->validateRequest($request));

        return redirect('/carti-scanate')->with('status', 'Cartea „' . ($carte_scanata->titlu ?? '') . '” a fost modificată cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CarteScanata  $carte_scanata
     * @return \Illuminate\Http\Response
     */
    public function destroy(CarteScanata $carte_scanata)
    {
        if (Gate::denies('modifica-carte-scanata', $carte_scanata)) {
            abort(403);
        }

        $carte_scanata->delete();

        return redirect('/carti-scanate')->with('status', 'Cartea „' . ($carte_scanata->titlu ?? '') . '” a a fost ștearsă cu succes!');
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
                'user_id' => 'required',
                'titlu' => 'required|max:500',
                'autor' => 'nullable|max:500',
                'editura' => 'nullable|max:500',
                'anul' => 'nullable|max:500',
                'nr_pagini' => 'nullable|numeric|integer|max:9999',
            ],
            [

            ]
        );
    }
}
