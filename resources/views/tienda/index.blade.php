<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sneaker Store - Tienda de Tenis</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Figtree', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col">

    <!-- Navbar Superior -->
    <nav class="bg-black text-white sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <span class="text-2xl">👟</span>
                    <div>
                        <a href="{{ route('tienda.index') }}" class="font-extrabold text-xl tracking-wider text-white hover:text-red-500 transition">
                            SNEAKER<span class="text-red-500">STORE</span>
                        </a>
                    </div>
                </div>

                <!-- Enlaces / Carrito / Login -->
                <div class="flex items-center gap-4">
                    <a href="{{ route('tienda.index') }}" class="text-sm font-semibold hover:text-red-400 transition hidden sm:inline">
                        Catálogo
                    </a>

                    <!-- Botón Carrito -->
                    <a href="{{ route('carrito.index') }}" class="relative bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-full font-bold text-xs uppercase tracking-wider flex items-center gap-2 transition shadow-sm">
                        <span>🛒 Carrito</span>
                        @if($totalCarrito > 0)
                            <span class="bg-white text-red-600 rounded-full px-2 py-0.5 text-xs font-black">
                                {{ $totalCarrito }}
                            </span>
                        @endif
                    </a>

                    <!-- Acceso / Cuenta de Usuario -->
                    @auth
                        <div class="flex items-center gap-2">
                            <!-- Temporizador de inactividad de 5 minutos -->
                            <div class="hidden md:flex items-center gap-1.5 text-[11px] bg-amber-950/80 border border-amber-600/60 text-amber-300 px-3 py-1.5 rounded-full font-mono font-bold" title="La sesión se cerrará automáticamente si no hay actividad en 5 minutos">
                                <span>⏱️ Inactividad:</span>
                                <span id="inactivity-timer" class="text-white font-extrabold">5:00</span>
                            </div>

                            <!-- Nombre del usuario con sesión activa -->
                            <div class="flex items-center gap-1.5 text-xs bg-gray-800 border border-gray-700 px-3 py-1.5 rounded-xl font-bold text-gray-200">
                                <span>{{ Auth::user()->isAdmin() ? '👑' : '👤' }}</span>
                                <span>{{ Auth::user()->name }}</span>
                                @if(Auth::user()->isAdmin())
                                    <span class="text-[10px] bg-red-600 text-white px-1.5 py-0.5 rounded font-black">ADMIN</span>
                                @endif
                            </div>

                            @if(Auth::user()->isAdmin())
                                <a href="{{ route('dashboard') }}" class="text-xs bg-red-600 hover:bg-black px-3 py-1.5 rounded-xl font-bold text-white transition shadow-sm">
                                    ⚙️ Panel Admin
                                </a>
                            @endif

                            <a href="{{ route('logout') }}" class="text-xs bg-gray-800 hover:bg-red-900 px-2.5 py-1.5 rounded-xl font-bold text-gray-300 transition" title="Cerrar sesión">
                                🚪 Salir
                            </a>
                        </div>
                    @else
                        <div class="flex items-center gap-2">
                            <a href="{{ route('login') }}" class="text-xs bg-gray-800 hover:bg-gray-700 px-3 py-2 rounded-xl font-bold text-gray-200 transition">
                                👤 Iniciar Sesión
                            </a>
                            <a href="{{ route('register') }}" class="text-xs bg-red-600 hover:bg-red-700 px-3 py-2 rounded-xl font-bold text-white transition">
                                Registrarse
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Alertas Flash -->
    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
            <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-xl flex items-center gap-2 shadow-sm font-bold text-sm">
                <span class="text-xl">⛔</span>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
            <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-xl flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2">
                    <span class="text-xl">✅</span>
                    <span class="font-medium text-sm">{{ session('success') }}</span>
                </div>
                <a href="{{ route('carrito.index') }}" class="text-xs font-bold bg-green-700 text-white px-3 py-1.5 rounded-lg hover:bg-green-800">
                    Ir al Carrito &rarr;
                </a>
            </div>
        </div>
    @endif

    <!-- Banner Hero -->
    <header class="bg-gradient-to-r from-gray-900 via-black to-gray-900 text-white py-12 px-4 sm:px-6 lg:px-8 shadow-inner">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-8">
            <div>
                <span class="text-xs font-bold text-red-500 uppercase tracking-widest bg-red-950/60 px-3 py-1 rounded-full border border-red-800">
                    Colección 2026
                </span>
                <h1 class="text-3xl sm:text-5xl font-black tracking-tight mt-3 text-white">
                    Los Tenis Más Exclusivos
                </h1>
                <p class="text-gray-400 mt-2 text-sm sm:text-base max-w-xl">
                    Encuentra las mejores marcas de calzado deportivo y urbano: Nike, Jordan, Adidas, Puma y más con envío garantizado.
                </p>
            </div>
            
            <!-- Barra de Búsqueda -->
            <form action="{{ route('tienda.index') }}" method="GET" class="w-full md:w-80 flex">
                <input 
                    type="text" 
                    name="buscar" 
                    value="{{ request('buscar') }}" 
                    placeholder="Buscar modelo o marca..." 
                    class="w-full px-4 py-2.5 rounded-l-xl text-sm bg-gray-800 border border-gray-700 text-white focus:outline-none focus:border-red-500"
                />
                <button type="submit" class="bg-red-600 hover:bg-red-700 px-4 py-2.5 rounded-r-xl text-white font-bold text-sm">
                    🔍
                </button>
            </form>
        </div>
    </header>

    <!-- Filtros de Marcas -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 w-full">
        <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none">
            <span class="text-xs font-bold text-gray-500 uppercase mr-2">Marcas:</span>
            
            <a href="{{ route('tienda.index') }}" class="px-4 py-1.5 rounded-full text-xs font-bold transition whitespace-nowrap {{ !request('marca') || request('marca') == 'todas' ? 'bg-black text-white' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-300' }}">
                Todas
            </a>

            @foreach($marcas as $m)
                <a href="{{ route('tienda.index', ['marca' => $m]) }}" class="px-4 py-1.5 rounded-full text-xs font-bold transition whitespace-nowrap {{ request('marca') == $m ? 'bg-black text-white' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-300' }}">
                    {{ $m }}
                </a>
            @endforeach
        </div>
    </section>

    <!-- Catálogo Grid -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16 w-full flex-1">
        @if($tenis->isEmpty())
            <div class="bg-white rounded-2xl p-12 text-center shadow-sm border border-gray-100">
                <span class="text-5xl">👟</span>
                <h3 class="text-lg font-bold text-gray-800 mt-4">No se encontraron tenis</h3>
                <p class="text-gray-500 text-sm mt-1">Prueba quitando los filtros o realizando otra búsqueda.</p>
                <a href="{{ route('tienda.index') }}" class="mt-4 inline-block bg-black text-white text-xs font-bold px-4 py-2 rounded-lg">
                    Ver todos los modelos
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach($tenis as $item)
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition duration-300 border border-gray-100 flex flex-col group">
                        
                        <!-- Imagen con etiqueta -->
                        <div class="relative bg-gray-100 h-64 overflow-hidden flex items-center justify-center p-4">
                            <img 
                                src="{{ $item->imagen }}" 
                                alt="{{ $item->nombre }}" 
                                class="w-full h-full object-cover rounded-xl group-hover:scale-105 transition duration-300"
                                loading="lazy"
                            />
                            <span class="absolute top-3 left-3 bg-black/80 backdrop-blur-sm text-white text-[10px] font-black uppercase px-2.5 py-1 rounded-md tracking-wider">
                                {{ $item->marca }}
                            </span>
                            <span class="absolute bottom-3 right-3 bg-white/90 backdrop-blur-sm text-gray-900 text-xs font-bold px-2 py-0.5 rounded shadow-sm">
                                Talla {{ $item->talla }}
                            </span>
                        </div>

                        <!-- Información -->
                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg group-hover:text-red-600 transition">
                                    {{ $item->nombre }}
                                </h3>
                                <p class="text-xs text-gray-500 mt-1 line-clamp-2">
                                    {{ $item->descripcion }}
                                </p>
                            </div>

                            <!-- Precio y Botón Agregar -->
                            <div class="mt-5 pt-4 border-t border-gray-100 flex items-center justify-between">
                                <div>
                                    <span class="text-[10px] uppercase text-gray-400 font-bold block">Precio</span>
                                    <span class="text-xl font-extrabold text-gray-900">
                                        ${{ number_format($item->precio, 2) }}
                                    </span>
                                </div>

                                <form action="{{ route('carrito.agregar', $item->id) }}" method="POST">
                                    @csrf
                                    <button 
                                        type="submit" 
                                        class="bg-red-600 hover:bg-black text-white px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition flex items-center gap-1.5 shadow-sm active:scale-95"
                                    >
                                        <span>+</span>
                                        <span>Agregar</span>
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 text-xs py-8 border-t border-gray-800 text-center">
        <div class="max-w-7xl mx-auto px-4">
            <p class="font-semibold text-gray-200">Sneaker Store &bull; Sistema de Ventas en Laravel</p>
            <p class="text-gray-500 mt-1">Proyecto de Desarrollo Web con PHP, MySQL y Laravel</p>
        </div>
    </footer>

    @auth
    <!-- Script de Inactividad y Sesión Única (Cierre instantáneo sin refrescar) -->
    <script>
        (function() {
            let timeoutSeconds = 300; // 5 minutos = 300 segundos
            let remaining = timeoutSeconds;
            let timerElement = document.getElementById('inactivity-timer');
            let isRedirecting = false;

            function closeSessionDueToInactivity() {
                if (isRedirecting) return;
                isRedirecting = true;
                window.location.replace("{{ route('logout') }}?reason=inactivity");
            }

            function resetTimer() {
                remaining = timeoutSeconds;
            }

            // Reiniciar temporizador con cualquier acción del usuario
            ['mousemove', 'mousedown', 'keydown', 'touchstart', 'scroll'].forEach(function(evt) {
                window.addEventListener(evt, resetTimer, { passive: true });
            });

            // Cuenta regresiva visual de 5 minutos
            setInterval(function() {
                if (isRedirecting) return;
                remaining--;
                if (timerElement) {
                    let m = Math.floor(remaining / 60);
                    let s = remaining % 60;
                    timerElement.textContent = m + ':' + (s < 10 ? '0' : '') + s;
                }

                if (remaining <= 0) {
                    closeSessionDueToInactivity();
                }
            }, 1000);

            function checkSessionStatus() {
                if (isRedirecting) return;
                fetch("{{ route('check.session') }}", {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    cache: 'no-store'
                })
                .then(function(res) {
                    return res.json();
                })
                .then(function(data) {
                    if (data && data.valid === false) {
                        closeSessionDueToInactivity();
                    }
                })
                .catch(function() {});
            }

            // Comprobar cada 1 segundo en segundo plano
            setInterval(checkSessionStatus, 1000);

            // Comprobar al instante si se vuelve a enfocar esta ventana
            window.addEventListener('focus', checkSessionStatus);
            document.addEventListener('visibilitychange', function() {
                if (document.visibilityState === 'visible') {
                    checkSessionStatus();
                }
            });
        })();
    </script>
    @endauth

</body>
</html>
