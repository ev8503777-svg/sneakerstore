<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Mostrar formulario de Login
    public function showLogin()
    {
        if (Auth::check()) {
            return Auth::user()->isAdmin() 
                ? redirect()->route('dashboard') 
                : redirect()->route('tienda.index');
        }
        return view('auth.login');
    }

    // Procesar Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'min:8'],
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debes ingresar un correo electrónico válido con arroba (@) y dominio (ej. usuario@correo.com).',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe contener al menos 8 caracteres.',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Asignar session_id para invalidar cualquier sesión en otro navegador
            $user = Auth::user();
            $user->session_id = $request->session()->getId();
            $user->save();

            // Garantizar que solo este usuario sea el activo en todo el sistema
            User::where('id', '!=', $user->id)->update(['session_id' => null]);

            // Inicializar tiempo de actividad fresco para evitar cierre inmediato
            session(['last_activity_time' => time()]);

            if ($user->isAdmin()) {
                return redirect()->route('dashboard')->with('success', 'Bienvenido al Panel de Administración.');
            }

            return redirect()->route('tienda.index')->with('success', '¡Bienvenido a la tienda, ' . $user->name . '!');
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    // Mostrar formulario de Registro
    public function showRegister()
    {
        if (Auth::check()) {
            return Auth::user()->isAdmin() 
                ? redirect()->route('dashboard') 
                : redirect()->route('tienda.index');
        }
        return view('auth.register');
    }

    // Procesar Registro
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[\pL\s]+$/u'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'El campo Nombre es obligatorio.',
            'name.min' => 'El campo Nombre debe tener al menos 3 caracteres.',
            'name.regex' => 'El campo Nombre solo debe contener letras y espacios (no números ni símbolos).',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debes ingresar un correo electrónico válido con formato arroba (@) y dominio (ej. usuario@correo.com).',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe contener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_admin' => 0,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        $user->session_id = $request->session()->getId();
        $user->save();

        User::where('id', '!=', $user->id)->update(['session_id' => null]);
        session(['last_activity_time' => time()]);

        return redirect()->route('tienda.index')->with('success', '¡Cuenta creada con éxito! Bienvenido a la tienda, ' . $user->name . '.');
    }

    // Cerrar sesión
    public function logout(Request $request)
    {
        $isInactivity = $request->query('reason') === 'inactivity';

        if (Auth::check()) {
            $user = Auth::user();
            // Solo limpiar session_id en BD si coincide con la sesión actual,
            // para evitar borrar la sesión activa del nuevo navegador
            if ($user->session_id === $request->session()->getId()) {
                $user->session_id = null;
                $user->save();
            }
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($isInactivity) {
            return redirect()->route('login')->with('warning', 'Tu sesión se cerró por inactividad. Iniciar sesión de nuevo.');
        }

        return redirect()->route('login')->with('info', 'Has cerrado sesión exitosamente.');
    }
}
