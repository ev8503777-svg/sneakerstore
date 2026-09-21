<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Figtree', sans-serif; }
        .red-gradient {
            position: absolute;
            top: 0;
            left: 0;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle at 10% 20%, rgba(255, 45, 32, 0.4), rgba(255, 45, 32, 0.1) 45%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }
    </style>
</head>
<body class="antialiased bg-white text-gray-800 relative min-h-screen overflow-x-hidden">

    <div class="red-gradient"></div>

    <!-- Navigation Top Right -->
    <div class="relative z-10 p-6 flex justify-end items-center gap-6 text-sm font-semibold text-gray-700">
        @if (Route::has('login'))
            @auth
                <a href="{{ url('/dashboard') }}" class="hover:text-gray-900 transition">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="hover:text-gray-900 transition">Acceso</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="hover:text-gray-900 transition">Registro</a>
                @endif
            @endauth
        @endif
    </div>

    <!-- Main Container -->
    <div class="relative z-10 max-w-6xl mx-auto px-6 pt-2 pb-16">
        <!-- Logo -->
        <div class="flex justify-center mb-10">
            <svg class="h-16 w-auto text-[#FF2D20] fill-current" viewBox="0 0 62 65" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M61.8548 14.6253C61.8105 14.49 61.7346 14.368 61.6329 14.2691L47.5312 0.548487C47.3377 0.358245 47.0754 0.25206 46.8021 0.25206H14.8698C14.5966 0.25206 14.3343 0.358245 14.1408 0.548487L0.0390625 14.2691C-0.0626305 14.368 -0.138547 14.49 -0.182813 14.6253C-0.227079 14.7607 -0.238478 14.9056 -0.216094 15.0483C-0.19371 15.1909 -0.13824 15.3268 -0.0541783 15.4452C0.0298836 15.5636 0.140026 15.6607 0.267344 15.7287L30.3444 31.7825C30.6019 31.9199 30.9069 31.9199 31.1644 31.7825L61.2415 15.7287C61.3688 15.6607 61.4789 15.5636 61.563 15.4452C61.647 15.3268 61.7025 15.1909 61.7249 15.0483C61.7473 14.9056 61.7359 14.7607 61.6916 14.6253H61.8548Z" fill="#FF2D20"/>
            </svg>
        </div>

        <!-- Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
            
            <!-- Left Card: Documentación -->
            <div class="bg-white rounded-2xl p-8 shadow-[0_4px_25px_rgba(0,0,0,0.06)] border border-gray-100 flex flex-col justify-between">
                <div>
                    <!-- Browser / Code preview illustration -->
                    <div class="border border-gray-200 rounded-xl p-5 mb-8 bg-gray-50/50">
                        <div class="flex items-center gap-2 mb-6">
                            <span class="text-xs font-bold text-red-500">Laravel</span>
                            <div class="ms-auto flex items-center bg-white border border-gray-200 rounded px-2 py-0.5 text-[10px] text-gray-400">
                                <span>Search</span>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="h-2 bg-gray-300 rounded w-1/3"></div>
                            <div class="h-2 bg-gray-200 rounded w-2/3"></div>
                            <div class="h-2 bg-gray-200 rounded w-full"></div>
                            <div class="h-2 bg-gray-200 rounded w-4/5"></div>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 mb-3">
                        <div class="w-10 h-10 rounded-full bg-red-100/70 flex items-center justify-center text-red-500 text-lg">
                            📖
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Documentación</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Laravel cuenta con una excelente documentación que abarca todos los aspectos del framework. Tanto si eres nuevo en Laravel como si ya tienes experiencia, te recomendamos leer nuestra documentación de principio a fin.
                    </p>
                </div>
            </div>

            <!-- Right Column Cards -->
            <div class="space-y-6">
                <!-- Laracasts -->
                <div class="bg-white rounded-2xl p-6 shadow-[0_4px_25px_rgba(0,0,0,0.06)] border border-gray-100 flex items-start gap-4">
                    <div class="w-11 h-11 rounded-xl bg-red-100/70 flex items-center justify-center text-red-500 text-xl shrink-0">
                        🎬
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <h4 class="text-base font-bold text-gray-900 mb-1">Laracasts</h4>
                            <span class="text-red-500 text-sm font-bold">&rarr;</span>
                        </div>
                        <p class="text-xs text-gray-600 leading-relaxed">
                            Laracasts ofrece miles de videotutoriales sobre desarrollo con Laravel, PHP y JavaScript. Échales un vistazo, compruébalo tú mismo y mejora enormemente tus habilidades de desarrollo.
                        </p>
                    </div>
                </div>

                <!-- Noticias de Laravel -->
                <div class="bg-white rounded-2xl p-6 shadow-[0_4px_25px_rgba(0,0,0,0.06)] border border-gray-100 flex items-start gap-4">
                    <div class="w-11 h-11 rounded-xl bg-red-100/70 flex items-center justify-center text-red-500 text-xl shrink-0">
                        📰
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <h4 class="text-base font-bold text-gray-900 mb-1">Noticias de Laravel</h4>
                            <span class="text-red-500 text-sm font-bold">&rarr;</span>
                        </div>
                        <p class="text-xs text-gray-600 leading-relaxed">
                            Laravel News es un portal y boletín informativo impulsado por la comunidad que recopila las noticias más recientes e importantes del ecosistema de Laravel, incluyendo lanzamientos de nuevos paquetes y tutoriales.
                        </p>
                    </div>
                </div>

                <!-- Ecosistema vibrante -->
                <div class="bg-white rounded-2xl p-6 shadow-[0_4px_25px_rgba(0,0,0,0.06)] border border-gray-100 flex items-start gap-4">
                    <div class="w-11 h-11 rounded-xl bg-red-100/70 flex items-center justify-center text-red-500 text-xl shrink-0">
                        🌐
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <h4 class="text-base font-bold text-gray-900 mb-1">Ecosistema vibrante</h4>
                            <span class="text-red-500 text-sm font-bold">&rarr;</span>
                        </div>
                        <p class="text-xs text-gray-600 leading-relaxed">
                            La sólida biblioteca de herramientas y librerías propias de Laravel, como Forge, Vapor, Nova, Envoyer y Herd, te ayuda a llevar tus proyectos al siguiente nivel. Combínalas con potentes librerías de código abierto...
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>
</html>
