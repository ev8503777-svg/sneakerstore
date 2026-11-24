<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenis;

class CarritoController extends Controller
{
    // Ver el carrito
    public function index()
    {
        $carrito = session('carrito', []);
        $total = 0;
        foreach ($carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        return view('tienda.carrito', compact('carrito', 'total'));
    }

    // Agregar producto al carrito
    public function agregar(Request $request, $id)
    {
        $tenis = Tenis::findOrFail($id);
        $carrito = session('carrito', []);

        if (isset($carrito[$id])) {
            $carrito[$id]['cantidad']++;
        } else {
            $carrito[$id] = [
                'id' => $tenis->id,
                'nombre' => $tenis->nombre,
                'marca' => $tenis->marca,
                'precio' => $tenis->precio,
                'talla' => $tenis->talla,
                'imagen' => $tenis->imagen,
                'cantidad' => 1,
            ];
        }

        session(['carrito' => $carrito]);

        return redirect()->back()->with('success', '¡"' . $tenis->nombre . '" agregado al carrito!');
    }

    // Eliminar producto del carrito
    public function eliminar($id)
    {
        $carrito = session('carrito', []);

        if (isset($carrito[$id])) {
            unset($carrito[$id]);
            session(['carrito' => $carrito]);
        }

        return redirect()->route('carrito.index')->with('success', 'Producto retirado del carrito.');
    }

    // Vaciar todo el carrito
    public function vaciar()
    {
        session()->forget('carrito');
        return redirect()->route('carrito.index')->with('info', 'El carrito ha sido vaciado.');
    }

    // Finalizar compra (Checkout simulado con ticket)
    public function checkout(Request $request)
    {
        $carrito = session('carrito', []);

        if (empty($carrito)) {
            return redirect()->route('tienda.index')->with('warning', 'Tu carrito está vacío.');
        }

        $request->validate([
            'nombre_cliente' => ['required', 'string', 'max:100', 'regex:/^[\pL\s]+$/u'],
            'telefono' => ['required', 'regex:/^[0-9]{10}$/'],
            'direccion' => ['required', 'string', 'max:255'],
            'metodo_pago' => ['required', 'string'],
        ], [
            'nombre_cliente.required' => 'El nombre del cliente es obligatorio.',
            'nombre_cliente.regex' => 'El campo Nombre del Comprador solo debe contener letras y espacios (no se permiten números ni caracteres especiales).',
            'telefono.required' => 'El teléfono de contacto es obligatorio.',
            'telefono.regex' => 'El teléfono debe contener exactamente 10 dígitos numéricos (solo números).',
            'direccion.required' => 'La dirección de entrega es obligatoria.',
            'metodo_pago.required' => 'Debe seleccionar un método de pago.',
        ]);

        $total = 0;
        foreach ($carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        $folio = 'SNEAKER-' . strtoupper(uniqid());
        $comprador = $request->input('nombre_cliente');
        $telefono = $request->input('telefono');
        $direccion = $request->input('direccion');
        $metodo = $request->input('metodo_pago', 'Tarjeta de Débito / Crédito');
        $itemsComprados = $carrito;

        // Limpiar carrito tras la compra
        session()->forget('carrito');

        return view('tienda.ticket', compact('folio', 'comprador', 'telefono', 'direccion', 'metodo', 'itemsComprados', 'total'));
    }
}
