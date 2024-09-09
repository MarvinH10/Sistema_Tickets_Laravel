<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sede;
use Illuminate\Support\Facades\Session;
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
