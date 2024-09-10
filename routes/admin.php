<?php

use App\Http\Controllers\Admin\SedeController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Admin\AulaController;
use App\Http\Controllers\Admin\PabellonController;
use App\Http\Controllers\Admin\TicketController;
use Inertia\Inertia;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Admin/Dashboard');
    })->name('dashboard');
    Route::get('/usuario', [UsuarioController::class, 'index'])->name('usuario');
    Route::get('/sede', [SedeController::class, 'index'])->name('sede');
    Route::get('/ticket', [TicketController::class, 'index'])->name('ticket');
    Route::get('/pabellon', [PabellonController::class, 'index'])->name('pabellon');
    Route::get('/aula', [AulaController::class, 'index'])->name('aula');
});