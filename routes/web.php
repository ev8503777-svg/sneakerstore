<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TiendaController;
use App\Http\Controllers\CarritoController;

// Página de inicio (redirige a la tienda de tenis o welcome)
Route::get('/', function () {
    return redirect()->route('tienda.index');
});

// Rutas de la Tienda de Tenis (Público)
Route::get('/tienda', [TiendaController::class, 'index'])->name('tienda.index');
Route::get('/tienda/{id}', [TiendaController::class, 'show'])->name('tienda.show');

// Rutas del Carrito de Compras (Público)
Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
Route::post('/carrito/agregar/{id}', [CarritoController::class, 'agregar'])->name('carrito.agregar');
Route::post('/carrito/eliminar/{id}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
Route::post('/carrito/vaciar', [CarritoController::class, 'vaciar'])->name('carrito.vaciar');
Route::post('/carrito/checkout', [CarritoController::class, 'checkout'])->name('carrito.checkout');

// Rutas de Autenticación (Login y Registro)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Rutas protegidas (Panel de Administración - EXCLUSIVO PARA ADMINISTRADOR)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Gestión de Tenis por el Administrador
    Route::post('/admin/tenis', [TiendaController::class, 'adminStore'])->name('admin.tenis.store');
    Route::put('/admin/tenis/{id}', [TiendaController::class, 'adminUpdate'])->name('admin.tenis.update');
    Route::delete('/admin/tenis/{id}', [TiendaController::class, 'adminDestroy'])->name('admin.tenis.destroy');
});

// Comprobar estado de la sesión en vivo (detecta inicio de sesión en otro navegador al instante)
Route::get('/check-session', function (\Illuminate\Http\Request $request) {
    if (!Auth::check()) {
        return response()->json(['valid' => false, 'reason' => 'unauthenticated']);
    }
    $user = Auth::user();
    $user->refresh();
    if (!$user->session_id || $user->session_id !== $request->session()->getId()) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json(['valid' => false, 'reason' => 'inactivity']);
    }
    return response()->json(['valid' => true]);
})->name('check.session');

// Cierre de sesión (accesible autenticado o tras invalidación para mostrar alerta flash)
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');
