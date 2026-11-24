<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionTimeout
{
    /**
     * Handle an incoming request.
     * Cierra la sesión automáticamente si han pasado más de 5 minutos de inactividad.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user->refresh();
            $currentSessionId = session()->getId();

            // 1. Comprobar si se inició sesión en otro navegador o con otro usuario (Sesión única)
            if (!$user->session_id || $user->session_id !== $currentSessionId) {
                Auth::logout();
                session()->invalidate();
                session()->regenerateToken();

                if ($request->is('*check-session*') || $request->is('check-session') || $request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'valid' => false,
                        'reason' => 'inactivity',
                        'message' => 'Tu sesión se cerró por inactividad. Iniciar sesión de nuevo.'
                    ]);
                }

                return redirect()->route('login')->with('warning', 'Tu sesión se cerró por inactividad. Iniciar sesión de nuevo.');
            }

            // 2. Comprobar inactividad de 5 minutos (300 segundos)
            $lastActivity = session('last_activity_time');
            $timeoutSeconds = 5 * 60; // 5 minutos = 300 segundos

            // Si es una sesión recién iniciada sin marca de tiempo, inicializarla ahora
            if (!$lastActivity) {
                session(['last_activity_time' => time()]);
                $lastActivity = time();
            }

            if (time() - $lastActivity > $timeoutSeconds) {
                if ($user->session_id === $currentSessionId) {
                    $user->session_id = null;
                    $user->save();
                }
                Auth::logout();
                session()->invalidate();
                session()->regenerateToken();

                if ($request->is('*check-session*') || $request->is('check-session') || $request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'valid' => false,
                        'reason' => 'inactivity',
                        'message' => 'Tu sesión se cerró por inactividad. Iniciar sesión de nuevo.'
                    ]);
                }

                return redirect()->route('login')->with('warning', 'Tu sesión se cerró por inactividad. Iniciar sesión de nuevo.');
            }

            // Actualizar la marca de tiempo de la última actividad del usuario (excluyendo peticiones de chequeo en segundo plano)
            if (!$request->is('*check-session*') && !$request->is('check-session')) {
                session(['last_activity_time' => time()]);
                // Mantener actualizado el timestamp en BD
                $user->touch();
            }
        } else {
            // CASO 2: El navegador NO tiene sesión activa (ej. se acaba de abrir en otro navegador)
            // IMPORTANTE: NUNCA auto-transferir si está en login, register, logout o check-session
            $isExcludedRoute = $request->is('*login*') || $request->is('*register*') || $request->is('*logout*') || $request->is('*check-session*');

            if (!$isExcludedRoute && $request->isMethod('GET')) {
                $activeUser = \App\Models\User::whereNotNull('session_id')
                    ->where('session_id', '!=', '')
                    ->orderBy('updated_at', 'desc')
                    ->first();

                // Comprobar que la sesión esté viva (menos de 5 minutos = 300 segundos de inactividad)
                if ($activeUser && $activeUser->updated_at && (now()->diffInSeconds($activeUser->updated_at) < 300)) {
                    // 1. Iniciar sesión automáticamente en este nuevo navegador
                    Auth::login($activeUser);
                    $request->session()->regenerate();

                    // 2. Reclamar el session_id para este nuevo navegador en la BD y asegurar que ningún otro usuario tenga session_id
                    $activeUser->session_id = $request->session()->getId();
                    $activeUser->save();
                    \App\Models\User::where('id', '!=', $activeUser->id)->update(['session_id' => null]);

                    session(['last_activity_time' => time()]);

                    return redirect($request->fullUrl());
                }
            }
        }

        return $next($request);
    }
}
