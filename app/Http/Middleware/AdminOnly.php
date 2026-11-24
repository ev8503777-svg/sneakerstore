<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOnly
{
    /**
     * Handle an incoming request.
     * Permite el acceso únicamente a usuarios administradores (admin@admin.com).
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('warning', 'Debes iniciar sesión como Administrador para acceder a esta área.');
        }

        if (!Auth::user()->isAdmin()) {
            return redirect()->route('tienda.index')->with('error', '⛔ Acceso denegado: Tu cuenta no tiene permisos de Administrador.');
        }

        return $next($request);
    }
}
