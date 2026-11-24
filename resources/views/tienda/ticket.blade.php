<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket de Compra - Sneaker Store</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Figtree', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 min-h-screen py-10 px-4 flex justify-center items-center">

    <div class="bg-white rounded-3xl shadow-xl max-w-xl w-full p-8 border border-gray-200">
        
        <!-- Encabezado de Éxito -->
        <div class="text-center pb-6 border-b border-dashed border-gray-300">
            <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-3xl mx-auto mb-3">
                ✓
            </div>
            <h1 class="text-2xl font-black text-gray-900 tracking-tight">¡Venta Completada con Éxito!</h1>
            <p class="text-xs text-gray-500 mt-1">Gracias por tu compra en Sneaker Store</p>
        </div>

        <!-- Datos del Ticket -->
        <div class="py-5 border-b border-dashed border-gray-300 grid grid-cols-2 gap-4 text-xs">
            <div>
                <span class="text-gray-400 uppercase font-bold block">Folio de Venta:</span>
                <span class="font-mono font-bold text-gray-900 text-sm">{{ $folio }}</span>
            </div>
            <div class="text-right">
                <span class="text-gray-400 uppercase font-bold block">Fecha:</span>
                <span class="font-bold text-gray-900">{{ date('d/m/Y H:i') }} hrs</span>
            </div>
            <div>
                <span class="text-gray-400 uppercase font-bold block">Cliente:</span>
                <span class="font-bold text-gray-900">{{ $comprador }}</span>
            </div>
            <div class="text-right">
                <span class="text-gray-400 uppercase font-bold block">Teléfono:</span>
                <span class="font-bold text-gray-900">{{ $telefono ?? 'N/A' }}</span>
            </div>
            <div class="col-span-2">
                <span class="text-gray-400 uppercase font-bold block">Dirección de Entrega:</span>
                <span class="font-bold text-gray-900">{{ $direccion ?? 'Entrega en Tienda' }}</span>
            </div>
            <div class="col-span-2">
                <span class="text-gray-400 uppercase font-bold block">Método de Pago:</span>
                <span class="font-bold text-gray-900">{{ $metodo }}</span>
            </div>
        </div>

        <!-- Lista de Tenis Comprados -->
        <div class="py-5 border-b border-gray-200">
            <h3 class="text-xs font-bold uppercase text-gray-400 mb-3 tracking-wider">Detalle del Pedido:</h3>
            <div class="space-y-3">
                @foreach($itemsComprados as $item)
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center gap-3">
                            <img src="{{ $item['imagen'] }}" alt="" class="w-10 h-10 object-cover rounded-lg border">
                            <div>
                                <h4 class="font-bold text-gray-900 text-xs">{{ $item['nombre'] }}</h4>
                                <span class="text-[10px] text-gray-500">Talla: {{ $item['talla'] }} &bull; Cant: {{ $item['cantidad'] }}</span>
                            </div>
                        </div>
                        <span class="font-bold text-gray-900">
                            ${{ number_format($item['precio'] * $item['cantidad'], 2) }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Total -->
        <div class="pt-4 flex justify-between items-center">
            <span class="text-base font-extrabold text-gray-900">Total Pagado:</span>
            <span class="text-2xl font-black text-green-600">${{ number_format($total, 2) }} MXN</span>
        </div>

        <!-- Botones de Acción -->
        <div class="mt-8 space-y-2 no-print">
            <button 
                onclick="window.print()" 
                class="w-full bg-gray-900 hover:bg-black text-white py-3 rounded-xl font-bold text-xs uppercase tracking-wider transition shadow"
            >
                🖨️ Imprimir Ticket de Venta
            </button>
            <a 
                href="{{ route('tienda.index') }}" 
                class="w-full bg-red-600 hover:bg-red-700 text-white py-3 rounded-xl font-bold text-xs uppercase tracking-wider text-center block transition shadow"
            >
                &larr; Volver al Catálogo de Tenis
            </a>
        </div>

    </div>

    @auth
    <!-- Script de Inactividad y Sesión Única -->
    <script>
        (function() {
            let isRedirecting = false;
            function closeSessionDueToInactivity() {
                if (isRedirecting) return;
                isRedirecting = true;
                window.location.replace("{{ route('logout') }}?reason=inactivity");
            }
            function checkSessionStatus() {
                if (isRedirecting) return;
                fetch("{{ route('check.session') }}", {
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                    cache: 'no-store'
                })
                .then(function(res) {
                    return res.json();
                })
                .then(function(data) {
                    if (data && data.valid === false) closeSessionDueToInactivity();
                })
                .catch(function() {});
            }

            setInterval(checkSessionStatus, 1000);
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
