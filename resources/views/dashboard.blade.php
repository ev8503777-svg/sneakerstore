<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Sneaker Store</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    <style>
        body { font-family: 'Figtree', sans-serif; }
        .bg-startbootstrap {
            background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.4) 0%, rgba(0, 0, 0, 0.75) 100%), url('{{ asset('assets/img/bg-masthead.jpg') }}'), url('/practica/public/assets/img/bg-masthead.jpg');
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }
    </style>
</head>
<body class="font-sans antialiased min-h-screen flex flex-col bg-startbootstrap">

    <!-- Navigation Bar -->
    <nav class="bg-white/95 backdrop-blur-md border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center gap-6">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center gap-2">
                        <span class="text-2xl">👟</span>
                        <a href="{{ route('tienda.index') }}" class="font-black text-lg text-gray-900">
                            SNEAKER<span class="text-red-600">STORE</span>
                        </a>
                    </div>

                    <!-- Enlaces -->
                    <div class="hidden sm:flex items-center space-x-4">
                        <a href="{{ route('dashboard') }}" class="text-xs font-bold text-red-600 uppercase border-b-2 border-red-600 pb-1">
                            Panel Admin
                        </a>
                        <a href="{{ route('tienda.index') }}" class="text-xs font-bold text-gray-600 hover:text-black uppercase">
                            Ver Tienda Pública
                        </a>
                        <a href="{{ route('carrito.index') }}" class="text-xs font-bold text-gray-600 hover:text-black uppercase">
                            Carrito
                        </a>
                    </div>
                </div>

                <!-- Usuario y Logout -->
                <div class="flex items-center space-x-3">
                    <!-- Temporizador de inactividad de 5 minutos -->
                    <div class="hidden sm:flex items-center gap-1.5 text-[11px] bg-amber-50 border border-amber-300 text-amber-900 px-3 py-1.5 rounded-xl font-mono font-bold" title="La sesión se cerrará automáticamente si no hay actividad en 5 minutos">
                        <span>⏱️ Inactividad:</span>
                        <span id="inactivity-timer" class="text-red-600 font-extrabold">5:00</span>
                    </div>

                    <span class="text-xs font-semibold text-gray-700 bg-gray-100 px-3 py-1.5 rounded-lg border">
                        👤 {{ Auth::user()->name }}
                    </span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-xs text-red-600 hover:text-red-800 font-bold bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition">
                            Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Heading -->
    <header class="bg-white/90 backdrop-blur-md shadow-sm">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="font-black text-2xl text-gray-900 leading-tight">
                    Panel de Administración de Ventas
                </h1>
                <p class="text-xs text-gray-500">Gestión de inventario de tenis y catálogo</p>
            </div>
            <a href="{{ route('tienda.index') }}" class="bg-red-600 hover:bg-black text-white px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition shadow-md">
                👟 Ir a la Tienda &rarr;
            </a>
        </div>
    </header>

    <!-- Contenido Principal -->
    <main class="flex-1 py-10 px-4 sm:px-6 lg:px-8 w-full max-w-7xl mx-auto space-y-8">
        
        <!-- Mensajes Flash -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-2xl shadow-md text-sm font-bold flex items-center gap-2">
                <span>✅</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Tarjeta de Bienvenida original -->
        <div class="bg-white/95 backdrop-blur-md rounded-2xl shadow-xl border border-white/50 p-6 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-green-600 bg-green-50 px-2.5 py-1 rounded-md">
                    Sesión Activa
                </span>
                <h2 class="text-xl font-black text-gray-900 mt-2">You're logged in!</h2>
                <p class="text-xs text-gray-500">Bienvenido al sistema de administración. Desde aquí puedes registrar nuevos modelos de tenis para tu tienda.</p>
            </div>
            <span class="text-xs font-semibold text-gray-500 bg-gray-100 px-3 py-1.5 rounded-full border">
                Start Bootstrap Theme
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Columna Izquierda: Formulario para Agregar Nuevo Tenis -->
            <div class="lg:col-span-1">
                <div class="bg-white/95 backdrop-blur-md rounded-2xl shadow-xl border border-white/50 p-6 sticky top-24">
                    <h3 class="text-base font-black text-gray-900 mb-4 pb-2 border-b border-gray-100 flex items-center gap-2">
                        <span>➕</span>
                        <span>Registrar Nuevo Tenis</span>
                    </h3>

                    <form action="{{ route('admin.tenis.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                        @csrf

                        @if ($errors->any())
                            <div class="bg-red-50 border border-red-200 text-red-700 px-3 py-2 rounded-xl text-xs space-y-1">
                                <p class="font-bold flex items-center gap-1">
                                    <span>⚠️</span> <span>Errores en el formulario:</span>
                                </p>
                                <ul class="list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Modelo / Nombre</label>
                            <input type="text" name="nombre" value="{{ old('nombre') }}" placeholder="Ej. Nike Dunk Low" required class="w-full px-3 py-2 text-xs bg-gray-50 border @error('nombre') border-red-500 @else border-gray-300 @enderror rounded-xl focus:outline-none focus:border-red-500">
                            @error('nombre')
                                <p class="text-[10px] text-red-600 mt-0.5 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Marca (Solo letras)</label>
                                <input type="text" name="marca" value="{{ old('marca', 'Nike') }}" placeholder="Nike, Adidas..." pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+" title="Solo se permiten letras" oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')" required class="w-full px-3 py-2 text-xs bg-gray-50 border @error('marca') border-red-500 @else border-gray-300 @enderror rounded-xl focus:outline-none focus:border-red-500">
                                @error('marca')
                                    <p class="text-[10px] text-red-600 mt-0.5 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Precio ($ MXN - Números)</label>
                                <input type="number" step="0.01" min="1" name="precio" value="{{ old('precio') }}" placeholder="2199.00" oninput="this.value = this.value.replace(/[^0-9.]/g, '')" required class="w-full px-3 py-2 text-xs bg-gray-50 border @error('precio') border-red-500 @else border-gray-300 @enderror rounded-xl focus:outline-none focus:border-red-500">
                                @error('precio')
                                    <p class="text-[10px] text-red-600 mt-0.5 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Talla (MX)</label>
                                <input type="text" name="talla" value="{{ old('talla') }}" placeholder="27.0 MX" required class="w-full px-3 py-2 text-xs bg-gray-50 border @error('talla') border-red-500 @else border-gray-300 @enderror rounded-xl focus:outline-none focus:border-red-500">
                                @error('talla')
                                    <p class="text-[10px] text-red-600 mt-0.5 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Color (Solo letras)</label>
                                <input type="text" name="color" value="{{ old('color') }}" placeholder="Rojo Blanco" required pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+" title="Solo letras y espacios" oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')" class="w-full px-3 py-2 text-xs bg-gray-50 border @error('color') border-red-500 @else border-gray-300 @enderror rounded-xl focus:outline-none focus:border-red-500">
                                @error('color')
                                    <p class="text-[10px] text-red-600 mt-0.5 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Imagen del Calzado (Subir archivo desde tu PC)</label>
                            <input 
                                type="file" 
                                name="imagen" 
                                id="input_imagen_tenis"
                                accept="image/png, image/jpeg, image/jpg, image/webp, image/gif"
                                class="w-full px-3 py-1.5 text-xs bg-gray-50 border @error('imagen') border-red-500 @else border-gray-300 @enderror rounded-xl focus:outline-none focus:border-red-500 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 cursor-pointer"
                                onchange="previewImage(event)"
                            >
                            <p class="text-[10px] text-gray-400 mt-1">Sube fotos descargadas en tu computadora (JPG, PNG, WEBP, GIF)</p>
                            @error('imagen')
                                <p class="text-[10px] text-red-600 mt-0.5 font-semibold">{{ $message }}</p>
                            @enderror

                            <!-- Vista previa de la imagen cargada desde la PC -->
                            <div id="preview_container" class="mt-2 hidden flex items-center gap-3 p-2 bg-red-50/50 border border-dashed border-red-200 rounded-xl">
                                <img id="preview_img" src="" alt="Vista previa" class="w-14 h-14 object-cover rounded-lg border border-red-200 shadow-sm">
                                <div class="text-xs">
                                    <span class="font-bold text-gray-800 block truncate max-w-[200px]" id="preview_name"></span>
                                    <span class="text-[10px] text-green-600 font-semibold flex items-center gap-1">✓ Imagen seleccionada de tu PC</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Descripción</label>
                            <textarea name="descripcion" rows="2" placeholder="Breve detalle de los tenis..." class="w-full px-3 py-2 text-xs bg-gray-50 border border-gray-300 rounded-xl focus:outline-none focus:border-red-500">{{ old('descripcion') }}</textarea>
                        </div>

                        <button type="submit" class="w-full bg-red-600 hover:bg-black text-white font-black text-xs uppercase tracking-wider py-2.5 rounded-xl shadow-md transition active:scale-95">
                            Guardar en Tienda
                        </button>
                    </form>
                </div>
            </div>

            <!-- Columna Derecha: Tabla de Tenis en Catálogo -->
            <div class="lg:col-span-2">
                <div class="bg-white/95 backdrop-blur-md rounded-2xl shadow-xl border border-white/50 p-6">
                    <div class="flex justify-between items-center mb-4 pb-2 border-b border-gray-100">
                        <h3 class="text-base font-black text-gray-900 flex items-center gap-2">
                            <span>📋</span>
                            <span>Inventario de Tenis en Venta</span>
                        </h3>
                        <span class="text-xs font-bold bg-gray-100 text-gray-600 px-3 py-1 rounded-full">
                            {{ count(\App\Models\Tenis::all()) }} Modelos
                        </span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead>
                                <tr class="text-gray-400 uppercase font-black border-b border-gray-100 text-[10px]">
                                    <th class="py-2.5">Tenis</th>
                                    <th class="py-2.5">Marca</th>
                                    <th class="py-2.5">Precio</th>
                                    <th class="py-2.5">Talla</th>
                                    <th class="py-2.5 text-right">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse(\App\Models\Tenis::orderBy('id', 'desc')->get() as $tenis)
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <td class="py-3 flex items-center gap-3">
                                            <img src="{{ $tenis->imagen }}" alt="" class="w-10 h-10 object-cover rounded-lg border">
                                            <div>
                                                <span class="font-bold text-gray-900 block">{{ $tenis->nombre }}</span>
                                                <span class="text-[10px] text-gray-400">{{ $tenis->color }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3 font-semibold text-gray-700">
                                            {{ $tenis->marca }}
                                        </td>
                                        <td class="py-3 font-black text-gray-900">
                                            ${{ number_format($tenis->precio, 2) }}
                                        </td>
                                        <td class="py-3 text-gray-500 font-semibold">
                                            {{ $tenis->talla }}
                                        </td>
                                        <td class="py-3 text-right">
                                            <div class="flex items-center justify-end gap-1.5">
                                                <button 
                                                    type="button" 
                                                    onclick='openEditModal(@json($tenis))'
                                                    class="inline-flex items-center gap-1 text-blue-600 hover:text-white bg-blue-50 hover:bg-blue-600 font-bold px-2 py-1 rounded-lg text-[11px] transition shadow-xs"
                                                    title="Editar este modelo"
                                                >
                                                    <span>✏️</span> <span>Editar</span>
                                                </button>
                                                <form action="{{ route('admin.tenis.destroy', $tenis->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este modelo?');" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center gap-1 text-red-600 hover:text-white bg-red-50 hover:bg-red-600 font-bold px-2 py-1 rounded-lg text-[11px] transition shadow-xs" title="Eliminar">
                                                        <span>🗑️</span> <span>Borrar</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-8 text-center text-gray-400">
                                            No hay tenis registrados en el sistema.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </main>

    <!-- Modal para Editar Tenis -->
    <div id="editModal" onclick="if(event.target === this) closeEditModal()" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full p-6 relative border border-gray-100 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between pb-3 mb-4 border-b border-gray-100">
                <h3 class="text-base font-black text-gray-900 flex items-center gap-2">
                    <span>✏️</span> <span>Editar Información del Tenis</span>
                </h3>
                <button type="button" onclick="closeEditModal()" class="text-gray-400 hover:text-gray-700 font-bold text-xl p-1 leading-none">&times;</button>
            </div>

            <form id="editForm" method="POST" enctype="multipart/form-data" class="space-y-3">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Modelo / Nombre</label>
                    <input type="text" id="edit_nombre" name="nombre" required class="w-full px-3 py-2 text-xs bg-gray-50 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Marca (Solo letras)</label>
                        <input type="text" id="edit_marca" name="marca" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+" title="Solo se permiten letras" oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')" required class="w-full px-3 py-2 text-xs bg-gray-50 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Precio ($ MXN - Números)</label>
                        <input type="number" step="0.01" min="1" id="edit_precio" name="precio" oninput="this.value = this.value.replace(/[^0-9.]/g, '')" required class="w-full px-3 py-2 text-xs bg-gray-50 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Talla (MX)</label>
                        <input type="text" id="edit_talla" name="talla" required class="w-full px-3 py-2 text-xs bg-gray-50 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Color (Solo letras)</label>
                        <input type="text" id="edit_color" name="color" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+" title="Solo letras y espacios" oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')" required class="w-full px-3 py-2 text-xs bg-gray-50 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Imagen del Calzado</label>
                    <div class="flex items-center gap-3 p-2 bg-gray-50 border border-gray-200 rounded-xl mb-2">
                        <img id="edit_preview_img" src="" alt="Vista previa" class="w-12 h-12 object-cover rounded-lg border border-gray-300">
                        <div class="text-[11px] text-gray-500 leading-tight">
                            <span class="font-bold text-gray-700 block">Imagen actual guardada</span>
                            <span>Si no deseas cambiarla, deja el campo de abajo vacío.</span>
                        </div>
                    </div>
                    <input 
                        type="file" 
                        name="imagen" 
                        id="edit_input_imagen"
                        accept="image/png, image/jpeg, image/jpg, image/webp, image/gif"
                        class="w-full px-3 py-1.5 text-xs bg-gray-50 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer"
                        onchange="previewEditImage(event)"
                    >
                    <p class="text-[10px] text-gray-400 mt-1">Opcional: Selecciona una nueva foto desde tu PC (JPG, PNG, WEBP, GIF)</p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Descripción</label>
                    <textarea id="edit_descripcion" name="descripcion" rows="2" class="w-full px-3 py-2 text-xs bg-gray-50 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500"></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-gray-100">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 text-xs font-bold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition">
                        Cancelar
                    </button>
                    <button type="submit" class="px-5 py-2 text-xs font-black text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md transition active:scale-95 uppercase tracking-wider">
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-black/90 backdrop-blur-md text-gray-400 text-xs py-4 text-center border-t border-gray-800">
        <p>Sneaker Store &bull; Panel de Control Administrativo en Laravel</p>
    </footer>

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

        // Previsualización de imagen descargada desde PC
        function previewImage(event) {
            const input = event.target;
            const container = document.getElementById('preview_container');
            const preview = document.getElementById('preview_img');
            const nameLabel = document.getElementById('preview_name');
            if (input.files && input.files[0]) {
                const file = input.files[0];
                preview.src = URL.createObjectURL(file);
                nameLabel.textContent = file.name;
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
            }
        }

        // Abrir modal de edición con datos cargados
        function openEditModal(tenis) {
            const form = document.getElementById('editForm');
            form.action = "{{ url('/admin/tenis') }}/" + tenis.id;
            document.getElementById('edit_nombre').value = tenis.nombre || '';
            document.getElementById('edit_marca').value = tenis.marca || '';
            document.getElementById('edit_precio').value = tenis.precio || '';
            document.getElementById('edit_talla').value = tenis.talla || '';
            document.getElementById('edit_color').value = tenis.color || '';
            document.getElementById('edit_descripcion').value = tenis.descripcion || '';
            document.getElementById('edit_preview_img').src = tenis.imagen || '';
            document.getElementById('edit_input_imagen').value = '';
            document.getElementById('editModal').classList.remove('hidden');
        }

        // Cerrar modal de edición
        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        // Vista previa de nueva imagen en el modal de edición
        function previewEditImage(event) {
            const input = event.target;
            const preview = document.getElementById('edit_preview_img');
            if (input.files && input.files[0]) {
                preview.src = URL.createObjectURL(input.files[0]);
            }
        }
    </script>

</body>
</html>
