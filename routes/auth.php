<?php

use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Route;

Route::get('/google/redirect', [GoogleController::class, 'redirect'])->name('google');
Route::get('/google/callback', [GoogleController::class, 'callback']);
