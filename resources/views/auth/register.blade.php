<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Laravel</title>
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

    <!-- Laravel 3D Isometric Cube Logo Outline -->
    <div class="mb-6">
        <a href="/">
            <svg class="w-16 h-16 text-gray-700 stroke-gray-700" viewBox="0 0 62 65" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Top Face -->
                <path d="M31 1.5L60.5 18.5L31 35.5L1.5 18.5L31 1.5Z" stroke="#4b5563" stroke-width="2.5" stroke-linejoin="round" fill="white"/>
                <!-- Left Face -->
                <path d="M1.5 18.5V53.5L31 70.5V35.5L1.5 18.5Z" stroke="#4b5563" stroke-width="2.5" stroke-linejoin="round" fill="white"/>
                <!-- Right Face -->
                <path d="M60.5 18.5V53.5L31 70.5V35.5L60.5 18.5Z" stroke="#4b5563" stroke-width="2.5" stroke-linejoin="round" fill="white"/>
                <!-- Small Inner Cube -->
                <path d="M46 10L56 16L46 22L36 16L46 10Z" stroke="#4b5563" stroke-width="2" stroke-linejoin="round" fill="white"/>
                <path d="M36 16V28L46 34V22L36 16Z" stroke="#4b5563" stroke-width="2" stroke-linejoin="round" fill="white"/>
                <path d="M56 16V28L46 34V22L56 16Z" stroke="#4b5563" stroke-width="2" stroke-linejoin="round" fill="white"/>
            </svg>
        </a>
    </div>

    <!-- Registration Card -->
    <div class="w-full max-w-[440px] bg-white rounded-xl shadow-[0_4px_25px_rgba(0,0,0,0.06)] border border-gray-100 p-8">
        
        @if ($errors->any())
            <div class="mb-4 text-xs text-red-600 bg-red-50 p-2.5 rounded-lg border border-red-200">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register.post') }}" class="space-y-4">
            @csrf

            <!-- Nombre -->
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5" for="name">
                    Nombre <span class="text-indigo-600 font-bold">(Solo letras)</span>
                </label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name') }}" 
                    pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+" 
                    title="Solo se permiten letras y espacios" 
                    oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')"
                    required 
                    autofocus
                    class="w-full px-3.5 py-2 text-sm bg-white border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-gray-900"
                />
            </div>

            <!-- Correo electrónico -->
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5" for="email">
                    Correo electrónico <span class="text-indigo-600 font-bold">(con @ y dominio)</span>
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}"
                    title="Debe incluir el signo @ y un dominio válido (ejemplo: usuario@correo.com)"
                    placeholder="ejemplo@correo.com"
                    required
                    class="w-full px-3.5 py-2 text-sm bg-white border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-gray-900"
                />
            </div>

            <!-- Contraseña -->
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5" for="password">
                    Contraseña <span class="text-indigo-600 font-bold">(Mínimo 8 caracteres)</span>
                </label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    minlength="8"
                    title="La contraseña debe tener al menos 8 caracteres"
                    placeholder="Mínimo 8 caracteres"
                    required
                    class="w-full px-3.5 py-2 text-sm bg-white border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-gray-900"
                />
            </div>

            <!-- Confirmar Contraseña -->
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5" for="password_confirmation">
                    Confirmar Contraseña <span class="text-indigo-600 font-bold">(Mínimo 8 caracteres)</span>
                </label>
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    minlength="8"
                    title="Repite la contraseña exactamente igual (mínimo 8 caracteres)"
                    placeholder="Repite la contraseña"
                    required
                    class="w-full px-3.5 py-2 text-sm bg-white border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-gray-900"
                />
            </div>

            <!-- Botón y Enlace -->
            <div class="flex items-center justify-end gap-4 pt-3">
                <a class="text-xs text-gray-600 hover:text-gray-900 underline" href="{{ route('login') }}">
                    ¿Ya estás registrado?
                </a>

                <button 
                    type="submit" 
                    class="bg-[#242c38] hover:bg-[#1a202c] text-white text-[11px] font-bold tracking-wider uppercase px-5 py-2.5 rounded-lg transition shadow-sm"
                >
                    REGISTRO
                </button>
            </div>
        </form>
    </div>

</body>
</html>
