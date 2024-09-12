<?php

use App\Http\Controllers\Admin\SedeController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Admin\AulaController;
use App\Http\Controllers\Admin\PabellonController;
use App\Http\Controllers\Admin\TicketController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Admin/Dashboard');
    })->name('dashboard');

    Route::controller(SedeController::class)->group(function () {
        Route::get('/sede', 'index')->name('sede');
        Route::get('/sedes', 'traer');
        Route::post('/sedes', 'store');
        Route::put('/sedes/{sede}', 'update');
        Route::delete('/sedes/{sede}', 'destroy');
    });


    Route::controller(UsuarioController::class)->group(function () {
        /** SOPORTE TÉCNICO **/
        Route::get('/soporte', 'soporte')->name('soporte');
        Route::get('/soportes', 'traerSoporte');
        Route::post('/soportes', 'storeSoporte');
        Route::put('/soportes/{soporte}', 'updateSoporte');
        Route::delete('/soportes/{soporte}', 'destroySoporte');
        /** DOCENTE **/
        Route::get('/docente', 'docente')->name('docente');
        Route::get('/docentes', 'traerDocente');
        Route::post('/docentes', 'storeDocente');
        Route::put('/docentes/{docente}', 'updateDocente');
        Route::delete('/docentes/{docente}', 'destroyDocente');
    });

    Route::controller(TicketController::class)->group(function () {
        Route::get('/ticket', 'index')->name('ticket');
    });

    Route::controller(PabellonController::class)->group(function () {
        Route::get('/pabellon', 'index')->name('pabellon');
        Route::get('/pabellons', 'traer');
        Route::post('/pabellons', 'store');
        Route::put('/pabellons/{pabellon}', 'update');
        Route::delete('/pabellons/{pabellon}', 'destroy');
    });

    Route::controller(AulaController::class)->group(function () {
        Route::get('/aula', 'index')->name('aula');
    });
});
