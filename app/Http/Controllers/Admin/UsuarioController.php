<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rol;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class UsuarioController extends Controller
{
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

    public function traerDocente()
    {
        $docentes = User::with('rol')
            ->whereHas('rol', function ($query) {
                $query->where('rol_nombre', 'Docente');
            })
            ->get();

        return response()->json($docentes);
    }

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

    public function storeDocente(Request $request)
    {
        $validarDatos = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:users,email',
            'celular' => 'required|string|max:30',
            'sed_id' => 'required|exists:sedes,id',
            'password' => 'required|string|min:8',
            'activo' => 'boolean',
        ]);

        $docente_rol = Rol::where('rol_nombre', 'Docente')->first();

        if (!$docente_rol) {
            return response()->json(['message' => 'Rol Docente no encontrado'], 404);
        }

        $validarDatos['password'] = bcrypt($validarDatos['password']);
        $validarDatos['rol_id'] = $docente_rol->id;

        $docente = User::create($validarDatos);

        return response()->json([
            'message' => 'Docente creado exitosamente',
            'docente' => $docente
        ], 201);
    }

    public function updateSoporte(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'celular' => 'required|string|max:30',
                'sed_id' => 'required|exists:sedes,id',
                'password' => 'nullable|string|min:8',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'msg' => 'Hubo errores en la validación',
                    'errors' => $validator->errors()->toArray(),
                ], 422);
            }

            $data = $request->only(['name', 'email', 'celular', 'sed_id']);
            if ($request->filled('password')) {
                $data['password'] = bcrypt($request->password);
            }

            $user->update($data);

            return response()->json([
                'status' => true,
                'msg' => 'Soporte Técnico actualizado correctamente',
                'user' => $user
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'msg' => 'Soporte técnico no encontrado'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'msg' => 'Error al actualizar el soporte técnico: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function updateDocente(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'celular' => 'required|string|max:30',
                'sed_id' => 'required|exists:sedes,id',
                'password' => 'nullable|string|min:8',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'msg' => 'Hubo errores en la validación',
                    'errors' => $validator->errors()->toArray(),
                ], 422);
            }

            $data = $request->only(['name', 'email', 'celular', 'sed_id']);
            if ($request->filled('password')) {
                $data['password'] = bcrypt($request->password);
            }

            $user->update($data);

            return response()->json([
                'status' => true,
                'msg' => 'Docente actualizado correctamente',
                'user' => $user
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'msg' => 'Docente no encontrado'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'msg' => 'Error al actualizar al docente: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroySoporte($id)
    {
        try {
            $user = User::findOrFail($id);

            $user->update(['activo' => 0]);

            return response()->json([
                'status' => true,
                'msg' => 'Soporte técnico desactivado exitosamente.',
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'msg' => 'Soporte técnico no encontrado.',
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'msg' => 'Ocurrió un error al desactivar el soporte técnico: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroyDocente($id)
    {
        try {
            $user = User::findOrFail($id);

            $user->update(['activo' => 0]);

            return response()->json([
                'status' => true,
                'msg' => 'Docente desactivado exitosamente.',
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'msg' => 'Docente no encontrado.',
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'msg' => 'Ocurrió un error al desactivar al docente: ' . $e->getMessage(),
            ], 500);
        }
    }
}
