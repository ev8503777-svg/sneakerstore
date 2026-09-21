<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Página de inicio (welcome con Acceso y Registro arriba)
Route::get('/', function () {
    return view('welcome');
});

// Rutas de Login y Registro
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Rutas protegidas (Dashboard)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
