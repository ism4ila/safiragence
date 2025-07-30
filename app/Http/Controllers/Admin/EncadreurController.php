<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Encadreur;
use Illuminate\Http\Request;

class EncadreurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $encadreurs = Encadreur::orderBy('full_name', 'asc')
                              ->orderBy('created_at', 'desc')
                              ->get();
        return view('admin.encadreurs.index', compact('encadreurs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.encadreurs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'city_id' => 'nullable|integer|exists:cities,id',
            'full_name' => 'required|string|max:255',
            'phone_1' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'specialties' => 'nullable|string',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->boolean('is_active', true);
        $data['created_by'] = auth()->id();

        Encadreur::create($data);

        return redirect()->route('admin.encadreurs.index')
                        ->with('success', 'Encadreur créé avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Encadreur $encadreur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Encadreur $encadreur)
    {
        return view('admin.encadreurs.edit', compact('encadreur'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Encadreur $encadreur)
    {
        $request->validate([
            'city_id' => 'nullable|integer|exists:cities,id',
            'full_name' => 'required|string|max:255',
            'phone_1' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'specialties' => 'nullable|string',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->boolean('is_active');

        $encadreur->update($data);

        return redirect()->route('admin.encadreurs.index')
                        ->with('success', 'Encadreur mis à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Encadreur $encadreur)
    {
        $encadreur->delete();
        
        return redirect()->route('admin.encadreurs.index')
                        ->with('success', 'Encadreur supprimé avec succès !');
    }
}
