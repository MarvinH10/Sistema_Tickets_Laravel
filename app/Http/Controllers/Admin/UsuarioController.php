<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function soporte()
    {
        return Inertia::render("Admin/Soporte");
    }

    public function traerSoporte()
    {
        $soportes = User::with('rol')
            ->whereHas('rol', function ($query) {
                $query->where('rol_nombre', 'Soporte');
            })
            ->get();

        return response()->json($soportes);
    }

    public function docente()
    {
        return Inertia::render("Admin/Docente");
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
    public function storeSoporte(Request $request)
    {
        $validarDatos = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:users,email',
            'celular' => 'required|string|max:30',
            'sed_id' => 'required|exists:sedes,id',
            'password' => 'required|string|min:8',
            'activo' => 'boolean',
        ]);

        $soporte_rol = Rol::where('rol_nombre', 'Soporte')->first();

        if (!$soporte_rol) {
            return response()->json(['message' => 'Rol Soporte no encontrado'], 404);
        }

        $validarDatos['password'] = bcrypt($validarDatos['password']);
        $validarDatos['rol_id'] = $soporte_rol->id;

        $soporte = User::create($validarDatos);

        return response()->json([
            'message' => 'Soporte técnico creado exitosamente',
            'soporte' => $soporte
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroySoporte($id)
    {
        try {
            $user = User::findOrFail($id);

            $user->update(['activo' => 0]);

            return response()->json([
                'status' => true,
                'msg' => 'Soporte técnico desactivado exitosamente.',
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'msg' => 'Soporte técnico no encontrado.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'msg' => 'Ocurrió un error al desactivar el soporte técnico: ' . $e->getMessage(),
            ], 500);
        }
    }
}
