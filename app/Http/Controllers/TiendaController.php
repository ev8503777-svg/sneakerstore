<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenis;

class TiendaController extends Controller
{
    // Mostrar el catálogo de tenis
    public function index(Request $request)
    {
        $query = Tenis::query();

        // Filtro por marca si se selecciona
        if ($request->filled('marca') && $request->marca !== 'todas') {
            $query->where('marca', $request->marca);
        }

        // Búsqueda por nombre
        if ($request->filled('buscar')) {
            $query->where('nombre', 'like', '%' . $request->buscar . '%');
        }

        $tenis = $query->orderBy('id', 'desc')->get();
        $marcas = Tenis::select('marca')->distinct()->pluck('marca');
        $totalCarrito = count(session('carrito', []));

        return view('tienda.index', compact('tenis', 'marcas', 'totalCarrito'));
    }

    // Detalle de un tenis
    public function show($id)
    {
        $tenis = Tenis::findOrFail($id);
        $totalCarrito = count(session('carrito', []));
        return view('tienda.show', compact('tenis', 'totalCarrito'));
    }

    // Guardar nuevo tenis desde el panel de administración
    public function adminStore(Request $request)
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'marca' => ['required', 'string', 'max:100', 'regex:/^[\pL\s]+$/u'],
            'precio' => ['required', 'numeric', 'min:1'],
            'talla' => ['required', 'string', 'max:50'],
            'color' => ['required', 'string', 'max:100', 'regex:/^[\pL\s]+$/u'],
            'imagen' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,gif', 'max:10240'],
            'descripcion' => ['nullable', 'string', 'max:500'],
        ], [
            'nombre.required' => 'El nombre del tenis es obligatorio.',
            'marca.required' => 'La marca es obligatoria.',
            'marca.regex' => 'La marca solo debe contener letras.',
            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número válido.',
            'precio.min' => 'El precio debe ser mínimo de $1.',
            'talla.required' => 'La talla es obligatoria.',
            'color.required' => 'El campo color es obligatorio.',
            'color.regex' => 'El campo Color solo debe contener letras y espacios (sin números).',
            'imagen.image' => 'El archivo seleccionado debe ser una imagen válida.',
            'imagen.mimes' => 'La imagen debe ser formato JPG, PNG, WEBP o GIF.',
            'imagen.max' => 'La imagen no debe pesar más de 10 MB.',
        ]);

        $imagenUrl = 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=800&auto=format&fit=crop';

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $uploadDir = public_path('uploads/tenis');
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $imagenUrl = asset('uploads/tenis/' . $filename);
        }

        Tenis::create([
            'nombre' => $request->nombre,
            'marca' => $request->marca,
            'precio' => $request->precio,
            'talla' => $request->talla,
            'color' => $request->color,
            'imagen' => $imagenUrl,
            'descripcion' => $request->descripcion ?: 'Calzado deportivo de alta calidad y diseño moderno.',
        ]);

        return redirect()->route('dashboard')->with('success', '¡Tenis registrado con éxito en el catálogo!');
    }

    // Actualizar tenis desde el panel de administración
    public function adminUpdate(Request $request, $id)
    {
        $tenis = Tenis::findOrFail($id);

        $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'marca' => ['required', 'string', 'max:100', 'regex:/^[\pL\s]+$/u'],
            'precio' => ['required', 'numeric', 'min:1'],
            'talla' => ['required', 'string', 'max:50'],
            'color' => ['required', 'string', 'max:100', 'regex:/^[\pL\s]+$/u'],
            'imagen' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,gif', 'max:10240'],
            'descripcion' => ['nullable', 'string', 'max:500'],
        ], [
            'nombre.required' => 'El nombre del tenis es obligatorio.',
            'marca.required' => 'La marca es obligatoria.',
            'marca.regex' => 'La marca solo debe contener letras.',
            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número válido.',
            'precio.min' => 'El precio debe ser mínimo de $1.',
            'talla.required' => 'La talla es obligatoria.',
            'color.required' => 'El campo color es obligatorio.',
            'color.regex' => 'El campo Color solo debe contener letras y espacios (sin números).',
            'imagen.image' => 'El archivo seleccionado debe ser una imagen válida.',
            'imagen.mimes' => 'La imagen debe ser formato JPG, PNG, WEBP o GIF.',
            'imagen.max' => 'La imagen no debe pesar más de 10 MB.',
        ]);

        $data = [
            'nombre' => $request->nombre,
            'marca' => $request->marca,
            'precio' => $request->precio,
            'talla' => $request->talla,
            'color' => $request->color,
            'descripcion' => $request->descripcion ?: 'Calzado deportivo de alta calidad y diseño moderno.',
        ];

        // Si se sube una nueva imagen desde la PC, guardarla y actualizar
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $uploadDir = public_path('uploads/tenis');
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $data['imagen'] = asset('uploads/tenis/' . $filename);
        }

        $tenis->update($data);

        return redirect()->route('dashboard')->with('success', '¡Tenis actualizado correctamente!');
    }

    // Eliminar tenis desde el panel de administración
    public function adminDestroy($id)
    {
        $tenis = Tenis::findOrFail($id);
        $tenis->delete();

        return redirect()->route('dashboard')->with('success', 'Tenis eliminado del catálogo correctamente.');
    }
}
