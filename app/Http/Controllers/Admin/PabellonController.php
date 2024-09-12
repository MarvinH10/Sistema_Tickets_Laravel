<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pabellon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PabellonController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Pabellon');
    }

    public function traer()
    {
        $pabellones = Pabellon::with('sede')->where('pab_activo', true)->get();
        return response()->json($pabellones);
    }

    public function store(Request $request)
    {
        $validarDatos = $request->validate([
            'pab_nombre' => 'required|string|max:255',
            'sed_id' => 'required|exists:sedes,id',
            'sed_activo' => 'boolean',
        ]);

        $pabellon = Pabellon::create($validarDatos);
        return response()->json($pabellon, 201);
    }

    public function update(Request $request, Pabellon $pabellon)
    {
        $validarDatos = $request->validate([
            'sed_id' => 'required|exists:sedes,id',
            'pab_nombre' => 'required|string|max:255',
            'pab_activo' => 'boolean',
        ]);

        $pabellon->update($validarDatos);

        return response()->json(['message' => 'Pabellón actualizado correctamente', 'pabellon' => $pabellon]);
    }

    public function destroy(Pabellon $pabellon)
    {
        $pabellon->update(['pab_activo' => 0]);
        return response()->json(['message' => 'Pabellón desactivado correctamente'], 200);
    }
}
