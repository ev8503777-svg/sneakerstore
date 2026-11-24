<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras - Sneaker Store</title>
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

    <!-- Navbar -->
    <nav class="bg-black text-white sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">👟</span>
                    <a href="{{ route('tienda.index') }}" class="font-extrabold text-xl tracking-wider text-white hover:text-red-500 transition">
                        SNEAKER<span class="text-red-500">STORE</span>
                    </a>
                </div>
                <div class="flex items-center gap-3">
                    @auth
                        <div class="hidden md:flex items-center gap-1.5 text-[11px] bg-amber-950/80 border border-amber-600/60 text-amber-300 px-3 py-1.5 rounded-full font-mono font-bold" title="La sesión se cerrará automáticamente si no hay actividad en 5 minutos">
                            <span>⏱️ Inactividad:</span>
                            <span id="inactivity-timer" class="text-white font-extrabold">5:00</span>
                        </div>
                        <span class="text-xs font-semibold text-gray-200 bg-gray-800 px-2.5 py-1.5 rounded-lg border border-gray-700">
                            👤 {{ Auth::user()->name }}
                        </span>
                    @endauth
                    <a href="{{ route('tienda.index') }}" class="text-xs bg-gray-800 hover:bg-gray-700 text-white px-3 py-2 rounded-lg font-semibold">
                        &larr; Volver al Catálogo
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Alertas Flash -->
    @if(session('success'))
        <div class="max-w-6xl mx-auto px-4 mt-6 w-full">
            <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-xl text-sm font-semibold">
                {{ session('success') }}
            </div>
        </div>
    @endif
    @if(session('info'))
        <div class="max-w-6xl mx-auto px-4 mt-6 w-full">
            <div class="bg-blue-100 border border-blue-300 text-blue-800 px-4 py-3 rounded-xl text-sm font-semibold">
                {{ session('info') }}
            </div>
        </div>
    @endif

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 w-full flex-1">
        <h1 class="text-3xl font-black text-gray-900 mb-8 flex items-center gap-3">
            <span>🛒 Tu Carrito de Compras</span>
        </h1>

        @if(empty($carrito))
            <div class="bg-white rounded-2xl p-12 text-center shadow-sm border border-gray-100">
                <span class="text-6xl">🛍️</span>
                <h2 class="text-xl font-bold text-gray-900 mt-4">Tu carrito está vacío</h2>
                <p class="text-gray-500 text-sm mt-1">Aún no has agregado tenis a tu pedido.</p>
                <a href="{{ route('tienda.index') }}" class="mt-6 inline-block bg-red-600 hover:bg-red-700 text-white font-bold text-sm px-6 py-3 rounded-xl shadow-md transition">
                    Explorar Tenis en Catálogo
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Lista de Productos en el Carrito -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                        <div class="flex justify-between items-center pb-4 border-b border-gray-100">
                            <span class="font-bold text-sm text-gray-500 uppercase">Productos ({{ count($carrito) }})</span>
                            <form action="{{ route('carrito.vaciar') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-xs text-red-500 hover:text-red-700 font-semibold underline">
                                    Vaciar Carrito
                                </button>
                            </form>
                        </div>

                        <div class="divide-y divide-gray-100">
                            @foreach($carrito as $id => $item)
                                <div class="py-4 flex flex-col sm:flex-row items-center gap-4">
                                    <!-- Imagen -->
                                    <img 
                                        src="{{ $item['imagen'] }}" 
                                        alt="{{ $item['nombre'] }}" 
                                        class="w-20 h-20 object-cover rounded-xl border border-gray-200"
                                    />
                                    
                                    <!-- Info -->
                                    <div class="flex-1 text-center sm:text-left">
                                        <span class="text-[10px] font-black uppercase text-gray-400 tracking-wider">
                                            {{ $item['marca'] }}
                                        </span>
                                        <h3 class="font-bold text-gray-900 text-base">
                                            {{ $item['nombre'] }}
                                        </h3>
                                        <p class="text-xs text-gray-500">
                                            Talla: <strong>{{ $item['talla'] }}</strong> &bull; Cantidad: <strong>{{ $item['cantidad'] }}</strong>
                                        </p>
                                    </div>

                                    <!-- Subtotal -->
                                    <div class="text-right">
                                        <span class="text-base font-extrabold text-gray-900 block">
                                            ${{ number_format($item['precio'] * $item['cantidad'], 2) }}
                                        </span>
                                        <span class="text-xs text-gray-400">
                                            ${{ number_format($item['precio'], 2) }} c/u
                                        </span>
                                    </div>

                                    <!-- Eliminar -->
                                    <form action="{{ route('carrito.eliminar', $id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-gray-400 hover:text-red-600 p-2 text-sm" title="Eliminar producto">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Resumen de Compra y Checkout -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 sticky top-24">
                        <h2 class="text-lg font-bold text-gray-900 mb-4 pb-3 border-b border-gray-100">
                            Resumen de Compra
                        </h2>

                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span>
                                <span>${{ number_format($total, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Envío nacional</span>
                                <span class="text-green-600 font-bold uppercase text-xs bg-green-50 px-2 py-0.5 rounded">¡GRATIS!</span>
                            </div>
                            <div class="border-t border-gray-100 pt-3 flex justify-between text-base font-black text-gray-900">
                                <span>Total a Pagar</span>
                                <span class="text-xl text-red-600">${{ number_format($total, 2) }} MXN</span>
                            </div>
                        </div>

                        <!-- Formulario de Checkout / Simular Pago -->
                        <form action="{{ route('carrito.checkout') }}" method="POST" class="mt-6 space-y-4">
                            @csrf

                            @if ($errors->any())
                                <div class="bg-red-50 border border-red-200 text-red-700 px-3 py-2 rounded-xl text-xs space-y-1">
                                    <p class="font-bold flex items-center gap-1">
                                        <span>⚠️</span> <span>Verifica los siguientes campos:</span>
                                    </p>
                                    <ul class="list-disc list-inside">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1" for="nombre_cliente">
                                    Nombre del Comprador <span class="text-red-500 font-bold">(Solo letras)</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="nombre_cliente" 
                                    name="nombre_cliente" 
                                    value="{{ old('nombre_cliente', Auth::check() ? Auth::user()->name : '') }}" 
                                    placeholder="Ej. Juan Pérez"
                                    pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+" 
                                    title="Solo se permiten letras y espacios"
                                    oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')"
                                    required
                                    class="w-full px-3 py-2 text-sm bg-gray-50 border @error('nombre_cliente') border-red-500 @else border-gray-300 @enderror rounded-xl focus:outline-none focus:border-red-500"
                                />
                                @error('nombre_cliente')
                                    <p class="text-[11px] text-red-600 mt-0.5 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1" for="telefono">
                                    Teléfono <span class="text-red-500 font-bold">(10 dígitos - Solo números)</span>
                                </label>
                                <input 
                                    type="tel" 
                                    id="telefono" 
                                    name="telefono" 
                                    value="{{ old('telefono') }}" 
                                    placeholder="Ej. 5512345678"
                                    maxlength="10"
                                    pattern="[0-9]{10}"
                                    title="Debe ingresar exactamente 10 dígitos numéricos"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                    required
                                    class="w-full px-3 py-2 text-sm bg-gray-50 border @error('telefono') border-red-500 @else border-gray-300 @enderror rounded-xl focus:outline-none focus:border-red-500"
                                />
                                @error('telefono')
                                    <p class="text-[11px] text-red-600 mt-0.5 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1" for="direccion">
                                    Dirección de Entrega
                                </label>
                                <input 
                                    type="text" 
                                    id="direccion" 
                                    name="direccion" 
                                    value="{{ old('direccion') }}" 
                                    placeholder="Calle, Número, Colonia, Ciudad"
                                    required
                                    class="w-full px-3 py-2 text-sm bg-gray-50 border @error('direccion') border-red-500 @else border-gray-300 @enderror rounded-xl focus:outline-none focus:border-red-500"
                                />
                                @error('direccion')
                                    <p class="text-[11px] text-red-600 mt-0.5 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1" for="metodo_pago">
                                    Método de Pago
                                </label>
                                <select 
                                    id="metodo_pago" 
                                    name="metodo_pago" 
                                    class="w-full px-3 py-2 text-sm bg-gray-50 border border-gray-300 rounded-xl focus:outline-none focus:border-red-500"
                                >
                                    <option value="Tarjeta de Débito / Crédito">💳 Tarjeta de Débito / Crédito</option>
                                    <option value="Pago en Efectivo (OXXO)">🏪 Pago en Efectivo (OXXO)</option>
                                    <option value="Transferencia SPEI">📱 Transferencia SPEI</option>
                                    <option value="PayPal">🅿️ PayPal</option>
                                </select>
                            </div>

                            <button 
                                type="submit" 
                                class="w-full bg-red-600 hover:bg-black text-white font-black text-sm uppercase tracking-wider py-3 rounded-xl shadow-lg transition active:scale-95 flex items-center justify-center gap-2"
                            >
                                <span>Pagar y Finalizar Pedido</span>
                                <span>&rarr;</span>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 text-xs py-6 border-t border-gray-800 text-center">
        <p>Sneaker Store &bull; Simulación de Venta en Laravel</p>
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
