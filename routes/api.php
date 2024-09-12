<?php

use App\Http\Controllers\Admin\SedeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Sede;
use App\Models\Pabellon;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/sedes', function () {
    return Sede::all();
});

Route::get('/pabellon', function () {
    return Pabellon::all();
});
