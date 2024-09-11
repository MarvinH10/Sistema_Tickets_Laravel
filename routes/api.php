<?php

use App\Http\Controllers\Admin\SedeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Sede;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/sedes', function () {
    return Sede::all();
});
