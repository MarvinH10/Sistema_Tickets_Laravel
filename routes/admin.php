<?php

use App\Http\Controllers\AulaController;
use App\Http\Controllers\PabellonController;
use App\Http\Controllers\TicketController;
use Inertia\Inertia;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Admin/Dashboard');
    })->name('dashboard');
    Route::get('/ticket', [TicketController::class, 'index'])->name('ticket');
    Route::get('/pabellon', [PabellonController::class, 'index'])->name('pabellon');
    Route::get('/aula', [AulaController::class, 'index'])->name('aula');
});