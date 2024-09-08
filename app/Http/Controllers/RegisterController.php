<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sede;
use Inertia\Inertia;

class RegisterController extends Controller
{
    public function create()
    {
        $sedes = Sede::all();

        return Inertia::render('Auth/Register', [
            'sedes' => $sedes,
        ]);
    }
}
