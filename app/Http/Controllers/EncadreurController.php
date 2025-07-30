<?php

namespace App\Http\Controllers;

use App\Models\Encadreur;
use Illuminate\Http\Request;

class EncadreurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $encadreurs = Encadreur::all();
        return view('encadreurs.index', compact('encadreurs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Encadreur $encadreur)
    {
        return view('encadreurs.show', compact('encadreur'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Encadreur $encadreur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Encadreur $encadreur)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Encadreur $encadreur)
    {
        //
    }
}
