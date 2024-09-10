<?php

use App\Http\Controllers\AulaController;
use App\Http\Controllers\PabellonController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\TicketController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

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