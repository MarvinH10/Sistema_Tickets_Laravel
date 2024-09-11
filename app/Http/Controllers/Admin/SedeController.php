<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sede;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SedeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Admin/Sedes');
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
        $validarDatos = $request->validate([
            'sed_nombre' => 'required|string|max:255',
            'sed_direccion' => 'required|string|max:255',
            'sed_ciudad' => 'required|string|max:255',
            'sed_telefono' => 'required|string|max:20',
            'sed_activo' => 'boolean',
        ]);

        $sede = Sede::create($validarDatos);
        return response()->json($sede, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Sede $sede)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sede $sede)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sede $sede)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sede $sede)
    {
        $sede->delete();
        return response()->json(['message' => 'Sede eliminada correctamente'], 200);
    }
}
