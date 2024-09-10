<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pabellon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PabellonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Admin/Pabellon');
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
    public function show(Pabellon $pabellon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pabellon $pabellon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pabellon $pabellon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pabellon $pabellon)
    {
        //
    }
}
