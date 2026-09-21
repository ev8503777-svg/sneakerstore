<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso - Laravel & Start Bootstrap</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #f3f4f6;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-center items-center px-4 py-8">

    <!-- Login Card -->
    <div class="w-full max-w-[440px] bg-white rounded-2xl shadow-[0_10px_35px_rgba(0,0,0,0.08)] border border-gray-100 overflow-hidden">
        
        <!-- Start Bootstrap Image Header -->
        <div class="relative w-full h-44 bg-gray-900 overflow-hidden">
            <img 
                src="{{ asset('assets/img/bg-masthead.jpg') }}" 
                alt="Start Bootstrap Grayscale" 
                class="w-full h-full object-cover opacity-85"
                onerror="this.onerror=null; this.src='/practica/public/assets/img/bg-masthead.jpg';"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent flex flex-col justify-end p-5 text-white">
                <span class="text-[10px] tracking-widest uppercase text-teal-300 font-bold">Start Bootstrap Theme</span>
                <h3 class="text-xl font-bold tracking-tight">Iniciar Sesión</h3>
            </div>
        </div>

        <div class="p-7">
            @if ($errors->any())
                <div class="mb-4 text-xs text-red-600 bg-red-50 p-2.5 rounded-lg border border-red-200">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
                @csrf

                <!-- Correo electrónico -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5" for="email">
                        Correo electrónico
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus
                        placeholder="ejemplo@correo.com"
                        class="w-full px-3.5 py-2 text-sm bg-white border border-gray-300 rounded-lg focus:outline-none focus:border-teal-600 focus:ring-1 focus:ring-teal-600 text-gray-900 shadow-sm"
                    />
                </div>

                <!-- Contraseña -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5" for="password">
                        Contraseña
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required
                        placeholder="••••••••"
                        class="w-full px-3.5 py-2 text-sm bg-white border border-gray-300 rounded-lg focus:outline-none focus:border-teal-600 focus:ring-1 focus:ring-teal-600 text-gray-900 shadow-sm"
                    />
                </div>

                <!-- Recordarme -->
                <div class="block">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-teal-600 shadow-sm focus:ring-teal-500 bg-white" name="remember">
                        <span class="ms-2 text-xs text-gray-600">Recordarme</span>
                    </label>
                </div>

                <!-- Botón y Enlace -->
                <div class="flex items-center justify-between pt-3">
                    <a class="text-xs text-gray-600 hover:text-gray-900 underline" href="{{ route('register') }}">
                        ¿No tienes cuenta? Registro
                    </a>

                    <button 
                        type="submit" 
                        class="bg-[#1f2937] hover:bg-black text-white text-[11px] font-bold tracking-wider uppercase px-5 py-2.5 rounded-lg transition shadow-sm"
                    >
                        ACCESO
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Enlace Volver al Inicio -->
    <div class="mt-4 text-center">
        <a href="/" class="text-xs text-gray-500 hover:text-gray-800">
            &larr; Volver al inicio
        </a>
    </div>

</body>
</html>
